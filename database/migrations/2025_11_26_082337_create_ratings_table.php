<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_ratings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id('rating_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items', 'item_id')->onDelete('cascade');
            $table->foreignId('rental_id')->nullable()->constrained('rentals', 'rental_id')->onDelete('set null');
            $table->foreignId('buy_id')->nullable()->constrained('buys', 'buy_id')->onDelete('set null');
            $table->foreignId('transaction_id')->nullable()->constrained('transactions', 'transaction_id')->onDelete('set null');
            $table->unsignedTinyInteger('rating_value')->comment('1 to 5');
            $table->text('comment')->nullable();
            $table->timestamps(); // Gunakan timestamps() untuk created_at dan updated_at

            // Indexes
            $table->index(['user_id', 'item_id']);
            $table->index(['rental_id']);
            $table->index(['buy_id']);
            $table->index(['transaction_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};