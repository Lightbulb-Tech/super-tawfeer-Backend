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
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->on('users')->references('id')->cascadeOnUpdate();
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->foreign('coupon_id')->on('coupons')->references('id')->cascadeOnUpdate();
            $table->string('coupon_type')->nullable();
            $table->string('coupon_discount')->nullable();
            $table->string('products_price');
            $table->string('app_commission')->nullable();
            $table->string('shipping_price')->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->foreign('area_id')->on('areas')->references('id')->cascadeOnUpdate();
            $table->string('lat')->nullable();
            $table->string('lon')->nullable();
            $table->string('final_price');

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
