<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_rentals', function (Blueprint $table) {
            $table->id('rental_detail_id');
            
            // Ini SEKARANG SUDAH BENAR karena rental_id jadi BIGINT
            $table->foreignId('rental_id')
                  ->constrained('rentals', 'rental_id')
                  ->onDelete('cascade');

            $table->unsignedSmallInteger('item_id');
            $table->unsignedTinyInteger('quantity')->default(1);
            $table->decimal('penalty', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('item_id')
                  ->references('item_id')
                  ->on('items')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_rentals');
    }
};