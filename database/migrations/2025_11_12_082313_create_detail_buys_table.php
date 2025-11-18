<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_buys', function (Blueprint $table) {
            $table->id('buy_detail_id');
            $table->foreignId('buy_id')->constrained('buys', 'buy_id')->onDelete('cascade');
            $table->unsignedSmallInteger('item_id');
            $table->unsignedTinyInteger('quantity');
            $table->decimal('total_price', 10, 2);
            $table->timestamps();

            $table->foreign('item_id')->references('item_id')->on('items')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_buys');
    }
};