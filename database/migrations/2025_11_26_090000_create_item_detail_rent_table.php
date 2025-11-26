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
            $table->foreignId('item_id')->constrained('items', 'item_id')->cascadeOnDelete();
            $table->string('status', 20)->nullable();
            $table->text('note')->nullable();
            $table->foreignId('current_rental_id')
                ->nullable()
                ->constrained('rentals', 'rental_id')
                ->nullOnDelete();
            $table->timestamps();

            $table->index('item_id');
            $table->index('current_rental_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_detail_rent');
    }
};
