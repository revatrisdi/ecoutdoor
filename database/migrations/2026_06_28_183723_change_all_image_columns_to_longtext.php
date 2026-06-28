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
        Schema::table('orders', function (Blueprint $table) {
            $table->longText('bukti_bayar')->nullable()->change();
        });
        Schema::table('return_requests', function (Blueprint $table) {
            $table->longText('bukti_foto')->nullable()->change();
        });
        Schema::table('reviews', function (Blueprint $table) {
            $table->longText('gambar')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('bukti_bayar')->nullable()->change();
        });
        Schema::table('return_requests', function (Blueprint $table) {
            $table->string('bukti_foto')->nullable()->change();
        });
        Schema::table('reviews', function (Blueprint $table) {
            $table->string('gambar')->nullable()->change();
        });
    }
};
