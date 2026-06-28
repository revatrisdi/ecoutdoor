<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('return_requests', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pesanan');          // kode pesanan (ECO-XXXXX)
            $table->string('nama_pembeli');           // nama pelapor
            $table->string('whatsapp');               // no WA untuk dihubungi
            $table->enum('alasan', [
                'barang_rusak',
                'barang_berbeda',
                'barang_tidak_sesuai_deskripsi',
                'lainnya',
            ])->default('lainnya');
            $table->text('deskripsi');                // detail masalah
            $table->string('bukti_foto')->nullable(); // path foto/video bukti
            $table->enum('status', ['pending', 'diproses', 'disetujui', 'ditolak'])->default('pending');
            $table->text('catatan_admin')->nullable(); // balasan admin
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('return_requests');
    }
};
