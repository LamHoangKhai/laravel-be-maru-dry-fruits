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
            $table->mediumInteger("stock_quantity")->default(0);
            $table->float("store_quantity", 8, 2)->default(0);
            $table->unsignedFloat("price", 8, 2);
            $table->tinyInteger("star")->default(5);
            $table->tinyInteger("status")->default(1)->comment("1:Show - 2:Hidden");
            $table->tinyInteger("feature")->default(2)->comment('1: Featured - 2: Unfeatured');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->longText('qrcode')->nullable();
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
