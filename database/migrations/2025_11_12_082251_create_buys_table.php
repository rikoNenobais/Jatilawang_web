<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buys', function (Blueprint $table) {
            $table->id('buy_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->timestamp('order_date')->useCurrent();
            $table->decimal('total_price', 10, 2)->nullable();
            $table->text('shipping_address')->nullable();
            
            // FIELD BARU
            $table->enum('payment_method', ['qris', 'transfer', 'cash'])->nullable();
            $table->enum('payment_status', ['menunggu_pembayaran', 'terbayar', 'gagal'])->default('menunggu_pembayaran');
            $table->enum('order_status', ['menunggu_verifikasi', 'dikonfirmasi', 'diproses', 'dikirim', 'selesai', 'dibatalkan'])->default('menunggu_verifikasi');
            $table->enum('delivery_option', ['pickup', 'delivery'])->default('pickup');
            $table->string('payment_proof')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buys');
    }
};