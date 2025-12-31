<?php

use App\Enums\AdminTypeisEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('email', 255)->unique();
            $table->string('phone', 255)->unique();
            $table->enum('admin_type', array_column(AdminTypeisEnum::cases(), 'value'))->default(AdminTypeisEnum::SuperAdmin->value);
            $table->string('password', 255);
            $table->string('image', 255);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
