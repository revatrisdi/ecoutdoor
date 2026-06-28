<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    /**
     * Tampilkan form checkout guest.
     */
    public function show(Request $request)
    {
        $directCheckoutItem = null;
        if ($request->has('id') && $request->has('qty')) {
            $product = Product::find($request->id);
            if ($product) {
                $directCheckoutItem = [
                    'id' => $product->id,
                    'name' => $product->nama_produk,
                    'price' => $product->harga,
                    'image' => $product->image_url,
                    'qty' => (int) $request->qty,
                    'stok' => $product->stok
                ];
            }
        }

        return view('checkout.guest', compact('directCheckoutItem'));
    }

    /**
     * Proses pembelian keranjang (multi-item).
     */
    public function process(Request $request): RedirectResponse
    {
        // Validasi form
        $validated = $request->validate([
            'nama_pembeli'      => ['required', 'string', 'max:255'],
            'no_whatsapp'       => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            'alamat_pengiriman' => ['required', 'string', 'min:10'],
            'metode_bayar'      => ['required', 'string', 'in:transfer,qris,cod'],
            'cart_items'        => ['required', 'string'],
        ], [
            'nama_pembeli.required'      => 'Nama lengkap wajib diisi.',
            'no_whatsapp.required'       => 'Nomor WhatsApp wajib diisi.',
            'no_whatsapp.regex'          => 'Format nomor WhatsApp tidak valid.',
            'alamat_pengiriman.required' => 'Alamat pengiriman wajib diisi.',
            'alamat_pengiriman.min'      => 'Alamat pengiriman terlalu singkat, mohon tulis lebih lengkap.',
            'metode_bayar.required'      => 'Metode pembayaran wajib dipilih.',
            'metode_bayar.in'            => 'Metode pembayaran tidak valid.',
            'cart_items.required'        => 'Keranjang belanja tidak valid.',
        ]);

        $cartItems = json_decode($validated['cart_items'], true);
        if (!is_array($cartItems) || empty($cartItems)) {
            return back()->with('error', 'Keranjang belanja kosong atau data tidak valid.');
        }

        // Format nomor WhatsApp agar selalu menggunakan prefix +62
        $wa = preg_replace('/[^0-9]/', '', $validated['no_whatsapp']);
        if (str_starts_with($wa, '0')) {
            $wa = '62' . substr($wa, 1);
        } elseif (!str_starts_with($wa, '62')) {
            $wa = '62' . $wa;
        }
        $validated['no_whatsapp'] = '+' . $wa;

        try {
            // Gunakan DB transaction agar stok dan order tersimpan atomik
            $order = DB::transaction(function () use ($validated, $cartItems) {
                $totalHarga = 0;
                $itemsData = [];

                // 1. Validasi stok dan hitung total harga
                foreach ($cartItems as $item) {
                    $product = Product::lockForUpdate()->findOrFail($item['id']);
                    $qty = (int) $item['qty'];

                    if ($qty < 1) {
                        throw new \Exception("Kuantitas produk tidak valid.");
                    }

                    if ($product->stok < $qty) {
                        throw new \Exception("Stok {$product->nama_produk} tidak mencukupi (sisa {$product->stok}).");
                    }

                    $subtotal = $product->harga * $qty;
                    $totalHarga += $subtotal;

                    $itemsData[] = [
                        'product' => $product,
                        'qty' => $qty,
                        'subtotal' => $subtotal,
                    ];
                }

                $adminFee = 2500;
                $totalHarga += $adminFee;

                // 2. Buat parent Order
                $order = Order::create([
                    'user_id'           => auth()->id(), // null jika guest
                    'nama_pembeli'      => $validated['nama_pembeli'],
                    'no_whatsapp'       => $validated['no_whatsapp'],
                    'alamat_pengiriman' => $validated['alamat_pengiriman'],
                    'total_harga'       => $totalHarga,
                    'status'            => 'pending',
                    'kode_pesanan'      => 'ECO-' . strtoupper(Str::random(8)),
                    'metode_bayar'      => $validated['metode_bayar'],
                ]);

                // 3. Kurangi stok dan buat OrderItem
                foreach ($itemsData as $data) {
                    $product = $data['product'];
                    $product->decrement('stok', $data['qty']);

                    $order->orderItems()->create([
                        'product_id' => $product->id,
                        'jumlah' => $data['qty'],
                        'harga_satuan' => $product->harga,
                        'subtotal' => $data['subtotal'],
                    ]);
                }

                return $order;
            });
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }

        // Simpan kode pesanan ke session browser agar muncul otomatis di "Pesanan Saya"
        $existing = session('pesanan_saya', []);
        if (! in_array($order->kode_pesanan, $existing)) {
            session()->push('pesanan_saya', $order->kode_pesanan);
        }

        // Semua metode bayar langsung ke halaman thank-you (ditambahkan param clear_cart)
        return redirect()->route('checkout.thankyou', ['kode' => $order->kode_pesanan, 'clear_cart' => 1]);
    }

    /**
     * Halaman Thank You setelah pembelian.
     */
    public function thankyou(Request $request)
    {
        $kode  = $request->query('kode');
        $order = Order::with('orderItems.product.user')->where('kode_pesanan', $kode)->firstOrFail();

        return view('checkout.thankyou', compact('order'));
    }

    /**
     * API endpoint: cek status pesanan dari DB.
     * Dipakai frontend untuk polling sederhana (tanpa Xendit).
     */
    public function status(Request $request): JsonResponse
    {
        $kode  = $request->query('kode');
        $order = Order::where('kode_pesanan', $kode)->firstOrFail();

        return response()->json([
            'status'  => $order->status,
            'paid_at' => $order->paid_at?->format('d M Y, H:i'),
        ]);
    }

    // ================================================================
    // UPLOAD BUKTI TRANSFER / QRIS
    // ================================================================

    /**
     * Pelanggan upload foto bukti transfer/QRIS.
     * POST /checkout/upload-bukti
     */
    public function uploadBukti(Request $request): RedirectResponse
    {
        $request->validate([
            'kode_pesanan' => ['required', 'string'],
            'bukti_bayar'  => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'], // maks 5MB
        ], [
            'bukti_bayar.required' => 'Foto bukti pembayaran wajib diupload.',
            'bukti_bayar.image'    => 'File harus berupa gambar (JPG/PNG/WebP).',
            'bukti_bayar.max'      => 'Ukuran file maksimal 5MB.',
        ]);

        $order = Order::where('kode_pesanan', $request->kode_pesanan)->firstOrFail();

        // Hanya boleh upload jika masih pending
        if ($order->status !== 'pending') {
            return redirect()->route('checkout.thankyou', ['kode' => $order->kode_pesanan])
                ->with('info', 'Pesanan ini sudah diproses.');
        }

        // Hapus bukti lama jika ada
        if ($order->bukti_bayar) {
            Storage::disk('public')->delete($order->bukti_bayar);
        }

        // Simpan file baru
        $path = $request->file('bukti_bayar')->store('bukti_bayar', 'public');

        $order->update([
            'bukti_bayar' => $path,
            'status'      => 'pending', // tetap pending sampai admin konfirmasi
        ]);

        return redirect()->route('checkout.thankyou', ['kode' => $order->kode_pesanan])
            ->with('success', 'Bukti pembayaran berhasil diupload! Admin akan segera mengkonfirmasi pesananmu.');
    }

    // ================================================================
    // DASHBOARD ADMIN
    // ================================================================

    /**
     * Dashboard admin: lihat semua order.
     * GET /admin/orders
     */
    public function adminOrders(Request $request)
    {
        $status = $request->query('status', 'semua');

        $query = Order::with('orderItems.product')->latest();

        if ($status !== 'semua') {
            $query->where('status', $status);
        }

        $orders = $query->paginate(20);

        return view('admin.orders', compact('orders', 'status'));
    }

    /**
     * Admin konfirmasi, tolak, atau update status pengiriman pesanan.
     * POST /admin/orders/{id}/confirm
     */
    public function confirmOrder(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'action'        => ['required', 'in:confirm,reject'],
            'catatan_admin' => ['nullable', 'string', 'max:500'],
            'status_baru'   => ['nullable', 'in:shipped,done'],
        ]);

        $order = Order::findOrFail($id);

        if ($request->action === 'confirm') {
            // Jika ada status_baru (update pengiriman), pakai itu; default: confirmed
            $newStatus = $request->status_baru ?? 'confirmed';
            $order->update([
                'status'        => $newStatus,
                'paid_at'       => $order->paid_at ?? now(),
                'catatan_admin' => $request->catatan_admin,
            ]);
            $msg = "Pesanan {$order->kode_pesanan} berhasil dikonfirmasi.";
        } else {
            // Tolak: kembalikan ke pending, hapus bukti agar pelanggan upload ulang
            if ($order->bukti_bayar) {
                Storage::disk('public')->delete($order->bukti_bayar);
            }
            $order->update([
                'status'        => 'pending',
                'bukti_bayar'   => null,
                'catatan_admin' => $request->catatan_admin ?? 'Bukti pembayaran ditolak, mohon upload ulang.',
            ]);
            $msg = "Bukti pembayaran pesanan {$order->kode_pesanan} ditolak.";
        }

        return redirect()->route('admin.orders')->with('success', $msg);
    }

    /**
     * Hapus pesanan (history).
     * DELETE /admin/orders/{id}
     */
    public function destroyOrder($id): RedirectResponse
    {
        $order = Order::findOrFail($id);

        // Hapus bukti transfer jika ada
        if ($order->bukti_bayar) {
            Storage::disk('public')->delete($order->bukti_bayar);
        }

        $order->delete();

        return redirect()->route('admin.orders')->with('success', "Riwayat pesanan {$order->kode_pesanan} berhasil dihapus.");
    }
}
