<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('warehouse', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("product_id");
            $table->unsignedBigInteger("supplier_id");
            $table->mediumInteger("quantity");
            $table->mediumInteger("current_quantity")->default(0);
            $table->tinyInteger("transaction_type")->comment("1: Export - 2: Import");
            $table->unsignedFloat("input_price", 8, 2);
            $table->string("shipment");
            $table->integer('import_price')->nullable();
            $table->date("transaction_date");
            $table->date("expiration_date");
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse');
    }
};
