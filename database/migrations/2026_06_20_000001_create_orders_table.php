<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel transaksi untuk mencatat riwayat pembelian guest maupun user login.
     * user_id nullable agar bisa diisi oleh guest tanpa akun.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Relasi ke user (nullable — guest checkout tidak punya user_id)
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Relasi ke produk
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            // Data pembeli (diisi manual oleh guest)
            $table->string('nama_pembeli');
            $table->string('no_whatsapp');
            $table->text('alamat_pengiriman');

            // Detail transaksi
            $table->integer('jumlah');           // qty yang dibeli
            $table->bigInteger('harga_satuan');  // snapshot harga saat transaksi
            $table->bigInteger('total_harga');   // harga_satuan × jumlah

            // Status pesanan
            $table->enum('status', ['pending', 'confirmed', 'shipped', 'done', 'cancelled'])
                  ->default('pending');

            // Kode unik pesanan untuk tracking
            $table->string('kode_pesanan')->unique();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
