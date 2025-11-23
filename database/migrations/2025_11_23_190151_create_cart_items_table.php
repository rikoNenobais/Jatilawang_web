<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id('cart_item_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items', 'item_id')->onDelete('cascade');
            $table->enum('type', ['rent', 'buy']);
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedInteger('days')->nullable(); // untuk rental
            $table->timestamps();
            
            // Satu user tidak bisa punya item yang sama dengan type yang sama
            $table->unique(['user_id', 'item_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};