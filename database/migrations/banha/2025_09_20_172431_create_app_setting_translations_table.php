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
        Schema::create('app_setting_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('app_setting_id')->unsigned();
            $table->string('locale')->index();

            $table->text('address')->nullable();
            $table->string('app_name')->nullable();

            $table->unique(['app_setting_id', 'locale']);
            $table->foreign('app_setting_id')->references('id')->on('app_settings')->onDelete('cascade')->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_setting_translations');
    }
};
