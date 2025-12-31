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
        Schema::create('vehicle_reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onUpdate('cascade')->onDelete('set null');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('from_address');
            $table->string('to_address');
            $table->string('first_lat');
            $table->string('first_lon');
            $table->string('second_lat');
            $table->string('second_lon');
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->text('details')->nullable();
            $table->double('price')->nullable();
            $table->double('number_of_km')->nullable();
            $table->double('price_of_km')->nullable();
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->foreign('coupon_id')->references('id')->on('vehicles')->onUpdate('cascade')->onDelete('set null');
            $table->string('coupon_type')->nullable();
            $table->string('coupon_value')->nullable();
            $table->string('final_price')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_reservations');
    }
};
