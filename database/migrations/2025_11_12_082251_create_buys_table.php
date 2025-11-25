<?php
// database/migrations/2024_01_04_create_buys_table.php
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
            
            // HANYA order & delivery fields  
            $table->enum('order_status', ['menunggu_verifikasi', 'dikonfirmasi', 'diproses', 'dikirim', 'selesai', 'dibatalkan'])->default('menunggu_verifikasi');
            $table->enum('delivery_option', ['pickup', 'delivery'])->default('pickup');
            $table->timestamp('shipped_at')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buys');
    }
};