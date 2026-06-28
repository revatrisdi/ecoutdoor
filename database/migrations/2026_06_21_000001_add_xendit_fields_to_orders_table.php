<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom Xendit & metode bayar ke tabel orders.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Metode pembayaran yang dipilih pelanggan
            $table->string('metode_bayar')->default('transfer')->after('kode_pesanan');

            // Data dari Xendit Invoice
            $table->string('xendit_invoice_id')->nullable()->after('metode_bayar');
            $table->string('xendit_invoice_url', 1000)->nullable()->after('xendit_invoice_id');

            // Waktu pembayaran terkonfirmasi
            $table->timestamp('paid_at')->nullable()->after('xendit_invoice_url');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['metode_bayar', 'xendit_invoice_id', 'xendit_invoice_url', 'paid_at']);
        });
    }
};
