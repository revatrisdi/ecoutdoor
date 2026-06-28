<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'nama_produk',
        'kategori',
        'deskripsi',
        'harga',
        'stok',
        'nama_file_gambar',
    ];

    /**
     * Setiap produk dimiliki oleh satu user (penjual/admin).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
