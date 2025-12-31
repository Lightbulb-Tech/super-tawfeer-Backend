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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_user_id')->nullable();
            $table->enum('form_user_table', ['users', 'admins'])->default('users');
            $table->unsignedBigInteger('to_user_id');
            $table->enum('to_user_table', ['users', 'admins'])->default('users');
            $table->string('title');
            $table->string('message', 1000);
            $table->boolean('is_read')->default(false);
            $table->string('action')->default('nothing');
            $table->unsignedBigInteger('operation_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
