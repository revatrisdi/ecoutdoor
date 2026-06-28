<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Simpan produk baru ke database.
     * File gambar dipindahkan ke public/images/.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi input
        $validated = $request->validate([
            'nama_produk' => ['required', 'string', 'max:255'],
            'kategori'    => ['required', 'string', 'in:Tenda,Tas & Carrier,Alas Kaki,Aksesoris'],
            'deskripsi'   => ['required', 'string'],
            'harga'       => ['required', 'integer', 'min:0'],
            'stok'        => ['required', 'integer', 'min:0'],
            'gambar'      => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'nama_produk.max'      => 'Nama produk maksimal 255 karakter.',
            'kategori.required'    => 'Kategori wajib dipilih.',
            'kategori.in'          => 'Pilihan kategori tidak valid.',
            'deskripsi.required'   => 'Deskripsi produk wajib diisi.',
            'harga.required'       => 'Harga wajib diisi.',
            'harga.integer'        => 'Harga harus berupa angka.',
            'harga.min'            => 'Harga tidak boleh negatif.',
            'stok.required'        => 'Stok wajib diisi.',
            'stok.integer'         => 'Stok harus berupa angka.',
            'stok.min'             => 'Stok tidak boleh negatif.',
            'gambar.required'      => 'Foto produk wajib diunggah.',
            'gambar.image'         => 'File harus berupa gambar.',
            'gambar.mimes'         => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'gambar.max'           => 'Ukuran gambar maksimal 2MB.',
        ]);

        // 2. Proses upload gambar ke public/images/
        $file      = $request->file('gambar');
        $extension = $file->getClientOriginalExtension();
        $fileName  = Str::slug($validated['nama_produk']) . '_' . time() . '.' . $extension;
        $file->move(public_path('images'), $fileName);

        // 3. Simpan ke database dengan user_id dari user yang sedang login
        Product::create([
            'user_id'          => auth()->id(),
            'nama_produk'      => $validated['nama_produk'],
            'kategori'         => $validated['kategori'],
            'deskripsi'        => $validated['deskripsi'],
            'harga'            => $validated['harga'] + 10000,
            'stok'             => $validated['stok'],
            'nama_file_gambar' => $fileName,
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Produk "' . $validated['nama_produk'] . '" berhasil diupload! 🎉');
    }

    /**
     * Tampilkan halaman detail produk (publik — bisa diakses guest).
     */
    public function show($id)
    {
        $product = Product::with(['user', 'reviews.user'])->findOrFail($id);
        
        $averageRating = $product->reviews->avg('rating') ?? 0;
        $totalReviews = $product->reviews->count();
        
        return view('products.show', compact('product', 'averageRating', 'totalReviews'));
    }

    /**
     * Tampilkan form edit produk (hanya pemilik yang boleh akses).
     */
    public function edit(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Kamu bukan pemilik produk ini.');
        }

        return view('products.edit', compact('product'));
    }

    /**
     * Proses update data produk. Gambar bersifat opsional.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Kamu bukan pemilik produk ini.');
        }

        $validated = $request->validate([
            'nama_produk' => ['required', 'string', 'max:255'],
            'kategori'    => ['required', 'string', 'in:Tenda,Tas & Carrier,Alas Kaki,Aksesoris'],
            'deskripsi'   => ['required', 'string'],
            'harga'       => ['required', 'integer', 'min:0'],
            'stok'        => ['required', 'integer', 'min:0'],
            'gambar'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'nama_produk.max'      => 'Nama produk maksimal 255 karakter.',
            'kategori.required'    => 'Kategori wajib dipilih.',
            'kategori.in'          => 'Pilihan kategori tidak valid.',
            'deskripsi.required'   => 'Deskripsi produk wajib diisi.',
            'harga.required'       => 'Harga wajib diisi.',
            'harga.integer'        => 'Harga harus berupa angka.',
            'harga.min'            => 'Harga tidak boleh negatif.',
            'stok.required'        => 'Stok wajib diisi.',
            'stok.integer'         => 'Stok harus berupa angka.',
            'stok.min'             => 'Stok tidak boleh negatif.',
            'gambar.image'         => 'File harus berupa gambar.',
            'gambar.mimes'         => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'gambar.max'           => 'Ukuran gambar maksimal 2MB.',
        ]);

        $fileName = $product->nama_file_gambar; // default: pakai gambar lama

        // Jika ada gambar baru, upload dan hapus gambar lama
        if ($request->hasFile('gambar')) {
            $file      = $request->file('gambar');
            $extension = $file->getClientOriginalExtension();
            $newName   = Str::slug($validated['nama_produk']) . '_' . time() . '.' . $extension;
            $file->move(public_path('images'), $newName);

            $oldPath = public_path('images/' . $product->nama_file_gambar);
            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }

            $fileName = $newName;
        }

        $product->update([
            'nama_produk'      => $validated['nama_produk'],
            'kategori'         => $validated['kategori'],
            'deskripsi'        => $validated['deskripsi'],
            'harga'            => $validated['harga'] + 10000,
            'stok'             => $validated['stok'],
            'nama_file_gambar' => $fileName,
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Produk "' . $validated['nama_produk'] . '" berhasil diperbarui! ✏️');
    }

    /**
     * Hapus produk beserta gambarnya (hanya pemilik yang boleh).
     */
    public function destroy(Product $product): RedirectResponse
    {
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Kamu bukan pemilik produk ini.');
        }

        $namaProduk = $product->nama_produk;

        $imagePath = public_path('images/' . $product->nama_file_gambar);
        if (file_exists($imagePath)) {
            @unlink($imagePath);
        }

        $product->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Produk "' . $namaProduk . '" berhasil dihapus.');
    }
}
