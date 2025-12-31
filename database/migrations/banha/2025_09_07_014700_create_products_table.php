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
            $table->unsignedBigInteger('main_category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->unsignedBigInteger('store_id')->nullable();
            $table->string('price');
            $table->string('image');
            $table->string('amount');
            $table->string('points')->default(0);
            $table->boolean('is_active')->default(0);
            $table->string('made_in_egypt')->default('no');
            $table->foreign('main_category_id')->on('categories')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('sub_category_id')->on('categories')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('store_id')->on('stores')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
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
