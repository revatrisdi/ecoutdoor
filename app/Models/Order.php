<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'nama_pembeli',
        'no_whatsapp',
        'alamat_pengiriman',
        'total_harga',
        'status',
        'kode_pesanan',
        'metode_bayar',
        'xendit_invoice_id',
        'xendit_invoice_url',
        'paid_at',
        'bukti_bayar',
        'catatan_admin',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    /** Relasi ke user (nullable — bisa null jika guest) */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Relasi ke Order Items */
    public function orderItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
