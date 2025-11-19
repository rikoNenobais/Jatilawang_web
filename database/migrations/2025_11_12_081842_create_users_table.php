<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id'); // AUTO_INCREMENT PRIMARY KEY
            $table->string('remember_token', 100)->nullable();
            $table->string('username', 50)->unique();
            $table->string('password', 255);
            $table->string('full_name', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('role', 20)->default('customer');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};