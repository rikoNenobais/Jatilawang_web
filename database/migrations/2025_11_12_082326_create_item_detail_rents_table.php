<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_detail_rent', function (Blueprint $table) {
            $table->string('rent_detail_id', 10)->primary();
            $table->unsignedSmallInteger('item_id');
            $table->string('status', 20)->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('current_rental_id')->nullable();
            $table->timestamps();

            $table->foreign('item_id')->references('item_id')->on('items')->onDelete('cascade');
            $table->foreign('current_rental_id')->references('rental_id')->on('rentals')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_detail_rent');
    }
};