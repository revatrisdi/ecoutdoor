<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Path file foto bukti transfer yang diupload pelanggan
            $table->string('bukti_bayar')->nullable()->after('paid_at');
            // Catatan dari admin saat konfirmasi/tolak
            $table->text('catatan_admin')->nullable()->after('bukti_bayar');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['bukti_bayar', 'catatan_admin']);
        });
    }
};
