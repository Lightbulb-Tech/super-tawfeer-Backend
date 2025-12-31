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
        Schema::create('product_attribute_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_attr_id')->unsigned();
            $table->string('locale')->index();

            $table->string('attribute_name');

            $table->unique(['product_attr_id', 'locale']);
            $table->foreign('product_attr_id')->references('id')->on('product_attributes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attribute_translations');
    }
};
