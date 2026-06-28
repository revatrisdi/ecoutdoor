<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'komentar' => ['required', 'string', 'max:1000'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'], // max 5MB
        ]);

        $userId = Auth::id();

        // Cek apakah user sudah membeli produk ini
        $hasBought = Order::where('user_id', $userId)
            ->whereHas('orderItems', function ($q) use ($product) {
                $q->where('product_id', $product->id);
            })->exists();

        if (!$hasBought) {
            return back()->with('error', 'Hanya pelanggan yang telah membeli produk ini yang dapat memberikan ulasan.');
        }

        // Cek apakah user sudah pernah mereview produk ini
        $existingReview = Review::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk produk ini.');
        }

        $path = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $imageType = $file->getClientMimeType();
            $imageData = base64_encode(file_get_contents($file->getRealPath()));
            $path = 'data:' . $imageType . ';base64,' . $imageData;
        }

        Review::create([
            'product_id' => $product->id,
            'user_id' => $userId,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
            'gambar' => $path,
        ]);

        return back()->with('success', 'Ulasan Anda berhasil dikirim! Terima kasih atas feedback-nya.');
    }
}
