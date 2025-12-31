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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')->on('orders')->references('id')->cascadeOnUpdate();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->on('products')->references('id')->cascadeOnUpdate();
            $table->string('price');
            $table->string('quantity');
            $table->unsignedBigInteger('offer_id')->nullable();
            $table->foreign('offer_id')->on('offers')->references('id')->cascadeOnUpdate();
            $table->string('offer_type')->nullable();
            $table->string('offer_discount')->nullable();
            $table->string('final_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
