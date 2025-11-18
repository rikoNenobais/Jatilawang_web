<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->unsignedSmallInteger('item_id')->primary(); // NUMBER(5)
            $table->string('item_name', 100);
            $table->text('description')->nullable();
            $table->string('category', 20)->nullable();
            $table->string('url_image', 255)->nullable();
            $table->decimal('rental_price_per_day', 10, 0)->nullable();
            $table->decimal('sale_price', 10, 0)->nullable();
            $table->unsignedTinyInteger('rental_stock')->default(0); // NUMBER(3)
            $table->unsignedTinyInteger('sale_stock')->default(0);
            $table->decimal('penalty_per_days', 10, 2)->default(0);
            $table->boolean('is_rentable')->default(true);
            $table->boolean('is_sellable')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};