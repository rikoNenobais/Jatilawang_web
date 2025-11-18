<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            
            // Ini adalah "Kunci Asing" yang menyambung ke tabel 'products'
            $table->foreignId('product_id')
                  ->constrained('products')      // terhubung ke tabel 'products'
                  ->onDelete('cascade');    // jika produk dihapus, fotonya ikut terhapus

            // Path ke file gambar, misal: 'foto-produk/carrier-belakang.png'
            $table->string('path');

            // Opsional: Untuk menandai mana gambar utama/cover
            $table->boolean('is_featured')->default(false); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
