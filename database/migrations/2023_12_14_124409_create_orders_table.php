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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->tinyInteger('status')->default(1)->comment('1: Pending - 2: Prepare - 3: Delivery - 4: Finish - 5: Cancel');
            $table->unsignedFloat("subtotal", 8, 2);
            $table->tinyInteger("discount")->default(0);
            $table->unsignedFloat("total", 8, 2);
            $table->tinyInteger('transaction')->comment('1: Cash/ShipCOD - 2: VNPAY');
            $table->tinyInteger('transaction_status')->comment('1: Completed - 2: Pending payment');
            $table->string('email');
            $table->string('full_name');
            $table->string('address');
            $table->string('phone');
            $table->string('note')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
