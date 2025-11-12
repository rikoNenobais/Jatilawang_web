<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('product_key')->index();
            $table->tinyInteger('rating')->unsigned();
            $table->text('comment')->nullable();
            $table->boolean('verified')->default(false);
            $table->timestamps();

            $table->unique(['user_id', 'product_key']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
