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
        Schema::create('external_order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('external_order_id')->nullable();
            $table->foreign('external_order_id')->references('id')->on('external_orders')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('order_category_id')->nullable();
            $table->foreign('order_category_id')->references('id')->on('order_categories')->onUpdate('cascade')->onDelete('set null');
            $table->text('details');
            $table->string('image');
            $table->double('price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_order_details');
    }
};
