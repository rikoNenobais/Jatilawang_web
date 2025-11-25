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
            $table->foreignId('rental_id')->constrained('rentals', 'rental_id')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items', 'item_id')->onDelete('cascade');
            $table->unsignedTinyInteger('quantity')->default(1);
            $table->decimal('penalty', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_rentals');
    }
};