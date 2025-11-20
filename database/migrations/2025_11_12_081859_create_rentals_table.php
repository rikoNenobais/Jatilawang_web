<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id('rental_id')->primary(); 
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->date('rental_start_date');
            $table->date('rental_end_date');
            $table->date('return_date')->nullable();
            $table->decimal('total_price', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};