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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('image');
            $table->text('description')->nullable();
            $table->text('nutrition_detail');
            $table->integer('stock_quantity');
            $table->bigInteger('price');
            $table->tinyInteger('status')->comment('1: Show', '2: Hidden')->default('1');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('products');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
