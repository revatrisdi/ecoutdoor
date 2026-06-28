<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderTrackingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReturnRequestController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function (\Illuminate\Http\Request $request) {
    $kategori = $request->query('kategori');
    $search = $request->query('search');
    
    $query = Product::query();
    
    if ($kategori) {
        $query->where('kategori', $kategori);
    }
    
    if ($search) {
        $query->where('nama_produk', 'like', '%' . $search . '%')
              ->orWhere('deskripsi', 'like', '%' . $search . '%');
    }
    
    $products = $query->get();
    
    return view('welcome', compact('products'));
});

// Halaman Statis Layanan
Route::view('/tentang-kami', 'pages.about')->name('pages.about');
Route::view('/faq', 'pages.faq')->name('pages.faq');
Route::view('/blog', 'pages.blog')->name('pages.blog');

// ===== RETURN / PENGEMBALIAN BARANG (PUBLIK) =====
Route::get('/kebijakan-return',    fn() => view('pages.return-policy'))->name('pages.return-policy');
Route::post('/return/ajukan',      [ReturnRequestController::class, 'store'])->name('return.store');
Route::get('/return/cek',          [ReturnRequestController::class, 'status'])->name('return.status');

// Halaman detail produk — publik
Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');

// ===== PESANAN SAYA (PUBLIK — TRACKING GUEST) =====
Route::get('/pesanan-saya',       [OrderTrackingController::class, 'index'])->name('pesanan.index');
Route::post('/pesanan-saya/fetch',[OrderTrackingController::class, 'fetch'])->name('pesanan.fetch');
Route::post('/pesanan-saya/{id}/complete', [OrderTrackingController::class, 'complete'])->name('pesanan.complete');
Route::post('/pesanan-saya/{id}/review', [OrderTrackingController::class, 'review'])->name('pesanan.review');

// ===== CHECKOUT (PUBLIK — GUEST CHECKOUT) =====
// PENTING: route statis (thankyou, status) harus di atas route wildcard ({id})
Route::get('/checkout/thankyou',     [CheckoutController::class, 'thankyou'])   ->name('checkout.thankyou');
Route::get('/checkout/status',       [CheckoutController::class, 'status'])     ->name('checkout.status');
Route::post('/checkout/upload-bukti',[CheckoutController::class, 'uploadBukti'])->name('checkout.upload-bukti');
Route::get('/checkout',         [CheckoutController::class, 'show'])       ->name('checkout.show');
Route::post('/checkout',        [CheckoutController::class, 'process'])    ->name('checkout.process');

Route::get('/dashboard', function () {
    if (auth()->user() && auth()->user()->isAdmin()) {
        return redirect()->route('admin.orders');
    }

    $ordersToProcess = \App\Models\Order::whereIn('status', ['confirmed', 'shipped', 'done'])
        ->whereHas('orderItems', function($q) {
            $q->where('seller_archived', false)
              ->whereHas('product', function($query) {
                  $query->where('user_id', auth()->id());
              });
        })->with(['orderItems' => function($q) {
            $q->whereHas('product', function($query) {
                $query->where('user_id', auth()->id());
            })->with('product');
        }])->orderBy('updated_at', 'desc')->get();

    return view('dashboard', compact('ordersToProcess'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Produk: upload produk baru
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    // Produk: edit, update, delete
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Action seller memproses pesanan (tandai dikirim)
    Route::patch('/dashboard/orders/{id}/ship', function($id) {
        $order = \App\Models\Order::findOrFail($id);
        // Validasi bahwa pesanan mengandung produk milik seller ini
        $hasProduct = \App\Models\OrderItem::where('order_id', $order->id)
            ->whereHas('product', function($q) {
                $q->where('user_id', auth()->id());
            })->exists();
            
        if ($hasProduct && $order->status === 'confirmed') {
            $order->update(['status' => 'shipped']);
            return back()->with('success', 'Pesanan ' . $order->kode_pesanan . ' berhasil ditandai sebagai "Sedang Dikirim"! Pembeli akan mendapatkan notifikasi.');
        }
        return back()->withErrors(['msg' => 'Gagal memproses pesanan.']);
    })->name('dashboard.orders.ship');

    // Action seller mengarsipkan (menghapus dari view) pesanan yang sudah selesai
    Route::delete('/dashboard/orders/{id}/archive', function($id) {
        $order = \App\Models\Order::findOrFail($id);
        if ($order->status === 'done') {
            \App\Models\OrderItem::where('order_id', $order->id)
                ->whereHas('product', function($q) {
                    $q->where('user_id', auth()->id());
                })->update(['seller_archived' => true]);
            return back()->with('success', 'Data pesanan berhasil dihapus dari dashboard.');
        }
        return back()->withErrors(['msg' => 'Pesanan belum selesai, tidak dapat dihapus.']);
    })->name('dashboard.orders.archive');

    // ===== ADMIN: Dashboard order & konfirmasi bukti bayar =====
    Route::middleware('is.admin')->group(function () {
        Route::get('/admin/orders',                [CheckoutController::class, 'adminOrders'])  ->name('admin.orders');
        Route::post('/admin/orders/{id}/confirm',  [CheckoutController::class, 'confirmOrder']) ->name('admin.confirm');
        Route::delete('/admin/orders/{id}',        [CheckoutController::class, 'destroyOrder']) ->name('admin.orders.destroy');

        // Kelola return requests
        Route::get('/admin/returns',               [ReturnRequestController::class, 'adminIndex'])  ->name('admin.returns');
        Route::patch('/admin/returns/{id}',        [ReturnRequestController::class, 'adminUpdate']) ->name('admin.returns.update');
        Route::delete('/admin/returns/{id}',       [ReturnRequestController::class, 'destroy'])     ->name('admin.returns.destroy');
    });

    // Submit review
    Route::post('/products/{product}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
});

require __DIR__.'/auth.php';
