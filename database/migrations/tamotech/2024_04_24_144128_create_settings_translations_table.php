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
        Schema::create('settings_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('settings_id')->unsigned();
            $table->string('locale')->index();
            $table->string('text_sidebar')->nullable();
            $table->string('text_login')->nullable();
            $table->string('subText_login')->nullable();
            $table->string('footer_text')->nullable();
            $table->unique(['settings_id', 'locale']);
            $table->foreign('settings_id')->references('id')->on('settings')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings_translations');
    }
};
