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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone');
            $table->string('phone_code');
            $table->string('email')->unique()->nullable();
            $table->string('image')->nullable();
            $table->string('lat')->nullable();
            $table->string('lon')->nullable();
            $table->string('points')->nullable()->default(0);
            $table->string('is_deleted')->nullable()->default(0);
            $table->string('is_blocked')->nullable()->default(0);
            $table->string('register_from');
            $table->string('register_type');
            $table->string('social_id')->nullable()->default('#');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
