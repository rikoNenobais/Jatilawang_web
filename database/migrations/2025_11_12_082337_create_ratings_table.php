<?php

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
            $table->unsignedSmallInteger('item_id');
            $table->unsignedBigInteger('rental_id')->nullable();
            $table->unsignedBigInteger('buy_id')->nullable();
            $table->unsignedTinyInteger('rating_value')->comment('1 to 5');
            $table->text('comment')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('item_id')->references('item_id')->on('items')->onDelete('cascade');
            $table->foreign('rental_id')->references('rental_id')->on('rentals')->onDelete('set null');
            $table->foreign('buy_id')->references('buy_id')->on('buys')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};