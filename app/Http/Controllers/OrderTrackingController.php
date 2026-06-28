<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrderTrackingController extends Controller
{
    /**
     * Halaman "Pesanan Saya" — render shell, data diisi via JS dari localStorage.
     */
    public function index(Request $request)
    {
        return view('pesanan.index');
    }

    /**
     * API endpoint: terima array kode_pesanan dari localStorage browser,
     * kembalikan data pesanan terkini dari DB (status, bukti, dll).
     *
     * POST /pesanan-saya/fetch
     * Body: { kode_list: ["ECO-XXXXX", ...] }
     */
    public function fetch(Request $request): JsonResponse
    {
        $kodeList = $request->input('kode_list', []);

        if (empty($kodeList) || ! is_array($kodeList)) {
            return response()->json(['orders' => []]);
        }

        // Batasi maksimal 50 kode agar tidak disalahgunakan
        $kodeList = array_slice(array_filter($kodeList), 0, 50);

        $orders = Order::with('orderItems.product')
            ->whereIn('kode_pesanan', $kodeList)
            ->latest()
            ->get()
            ->map(function ($order) {
                $firstItem = $order->orderItems->first();
                $productNames = $order->orderItems->map(fn($i) => $i->product->nama_produk)->join(', ');
                if (strlen($productNames) > 35) $productNames = substr($productNames, 0, 32) . '...';
                
                $hasReviewed = \App\Models\Review::where('order_id', $order->id)->exists();
                $returnReq = \App\Models\ReturnRequest::where('kode_pesanan', $order->kode_pesanan)->first();

                return [
                    'id'                => $order->id,
                    'kode_pesanan'      => $order->kode_pesanan,
                    'status'            => $order->status,
                    'metode_bayar'      => $order->metode_bayar,
                    'jumlah'            => $order->orderItems->sum('jumlah'),
                    'total_harga'       => $order->total_harga,
                    'created_at'        => $order->created_at->format('d M Y'),
                    'has_bukti'         => ! empty($order->bukti_bayar),
                    'has_reviewed'      => $hasReviewed,
                    'return_status'     => $returnReq ? $returnReq->status : null,
                    'return_alasan'     => $returnReq ? $returnReq->alasan_label : null,
                    'return_deskripsi'  => $returnReq ? $returnReq->deskripsi : null,
                    'return_rekening'   => $returnReq ? $returnReq->info_rekening : null,
                    'return_catatan'    => $returnReq ? $returnReq->catatan_admin : null,
                    'return_created_at' => $returnReq ? $returnReq->created_at->format('d M Y, H:i') : null,
                    'catatan_admin'     => $order->catatan_admin,
                    'paid_at'           => $order->paid_at?->format('d M Y, H:i'),
                    'thankyou_url'      => route('checkout.thankyou', ['kode' => $order->kode_pesanan]),
                    'product_nama'      => $productNames ?: '-',
                    'product_gambar'    => $firstItem->product->nama_file_gambar ?? null,
                    'product_id'        => $firstItem->product_id ?? null,
                ];
            });

        return response()->json(['orders' => $orders]);
    }

    public function complete($id): JsonResponse
    {
        $order = Order::findOrFail($id);
        
        if ($order->status === 'shipped') {
            $order->update(['status' => 'done']);
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false, 'message' => 'Status pesanan tidak valid untuk diselesaikan.'], 400);
    }

    public function review(Request $request, $id): JsonResponse
    {
        $order = Order::findOrFail($id);
        
        if ($order->status !== 'done') {
            return response()->json(['success' => false, 'message' => 'Pesanan belum selesai, tidak bisa di-review.'], 400);
        }

        $request->validate([
            'reviewer_name' => 'required|string|max:100',
            'rating'        => 'required|integer|min:1|max:5',
            'komentar'      => 'required|string|max:1000',
            'gambar'        => 'nullable|image|max:3072',
        ]);

        // Cek apakah sudah pernah direview
        $exists = \App\Models\Review::where('order_id', $order->id)->exists();
        if ($exists) {
            return response()->json(['success' => false, 'message' => 'Anda sudah memberikan ulasan untuk pesanan ini.'], 400);
        }

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $imageType = $file->getClientMimeType();
            $imageData = base64_encode(file_get_contents($file->getRealPath()));
            $gambarPath = 'data:' . $imageType . ';base64,' . $imageData;
        }

        // Simpan review (bisa bulk jika order punya banyak produk, tapi kita simpan ke produk pertama untuk simplicity, atau looping)
        // Di sini saya buat melooping order items untuk memberikan review ke semua produk dalam order (atau produk pertama saja).
        // Lebih baik produk pertama saja karena ulasannya 1 untuk order ini.
        $firstItem = $order->orderItems->first();
        if ($firstItem) {
            \App\Models\Review::create([
                'product_id'    => $firstItem->product_id,
                'order_id'      => $order->id,
                'user_id'       => null,
                'reviewer_name' => $request->reviewer_name,
                'rating'        => $request->rating,
                'komentar'      => $request->komentar,
                'gambar'        => $gambarPath,
            ]);
        }

        return response()->json(['success' => true]);
    }
}

