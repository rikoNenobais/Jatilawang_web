<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id('transaction_item_id');
            $table->foreignId('transaction_id')->constrained('transactions', 'transaction_id')->onDelete('cascade');
            $table->enum('order_type', ['rental', 'buy']);
            $table->unsignedBigInteger('order_id'); // rental_id atau buy_id
            $table->decimal('amount', 10, 2);
            $table->timestamps();

            $table->index(['order_type', 'order_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_items');
    }
};