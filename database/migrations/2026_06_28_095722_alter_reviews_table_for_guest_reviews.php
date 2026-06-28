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
        Schema::table('reviews', function (Blueprint $table) {
            // Kita ubah user_id menjadi nullable
            $table->dropForeign(['user_id']);
            $table->foreignId('user_id')->nullable()->change();
            
            // Tambahkan kolom baru
            $table->string('reviewer_name')->nullable()->after('user_id');
            $table->foreignId('order_id')->nullable()->after('product_id')->constrained('orders')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropColumn(['reviewer_name', 'order_id']);
            
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }
};
