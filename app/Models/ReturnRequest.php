<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnRequest extends Model
{
    protected $fillable = [
        'kode_pesanan',
        'nama_pembeli',
        'whatsapp',
        'alasan',
        'deskripsi',
        'bukti_foto',
        'status',
        'catatan_admin',
        'info_rekening',
    ];

    const ALASAN_LABELS = [
        'barang_rusak'                  => '🔨 Barang Rusak / Cacat',
        'barang_berbeda'                => '📦 Barang Berbeda dari Pesanan',
        'barang_tidak_sesuai_deskripsi' => '📝 Tidak Sesuai Deskripsi',
        'lainnya'                       => '❓ Lainnya',
    ];

    const STATUS_LABELS = [
        'pending'   => 'Menunggu Tinjauan',
        'diproses'  => 'Sedang Diproses',
        'disetujui' => 'Disetujui',
        'ditolak'   => 'Ditolak',
    ];

    public function getAlasanLabelAttribute(): string
    {
        return self::ALASAN_LABELS[$this->alasan] ?? $this->alasan;
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }

    public function getBuktiUrlAttribute()
    {
        if (!$this->bukti_foto) return null;
        if (str_starts_with($this->bukti_foto, 'data:image')) {
            return $this->bukti_foto;
        }
        return \Illuminate\Support\Facades\Storage::url($this->bukti_foto);
    }
}
