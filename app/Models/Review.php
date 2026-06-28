<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'product_id',
        'order_id',
        'user_id',
        'reviewer_name',
        'rating',
        'komentar',
        'gambar',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getGambarUrlAttribute()
    {
        if (!$this->gambar) return null;
        if (str_starts_with($this->gambar, 'data:image')) {
            return $this->gambar;
        }
        return \Illuminate\Support\Facades\Storage::url($this->gambar);
    }
}
