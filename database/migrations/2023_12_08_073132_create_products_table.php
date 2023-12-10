<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string("name");
            $table->string("image");
            $table->text("description");
            $table->text("nutrition_detail");
            $table->bigInteger("stock_quantity")->default(0);
            $table->unsignedFloat("price", 8, 2);
            $table->tinyInteger("status")->default(1)->comment("1:Show - 2:Hidden");
            $table->foreign('category_id')->references('id')->on('categories');
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
