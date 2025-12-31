<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reason_cancellation_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('reason_id')->unsigned();
            $table->string('locale')->index();

            $table->string('title');

            $table->unique(['reason_id', 'locale']);
            $table->foreign('reason_id')->references('id')->on('reason_cancellations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reason_cancellation_translations');
    }
};
