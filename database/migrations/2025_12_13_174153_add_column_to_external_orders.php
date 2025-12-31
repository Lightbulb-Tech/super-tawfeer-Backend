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
        Schema::table('external_orders', function (Blueprint $table) {
            $table->double('orders_price')->nullable()->after('shipping_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('external_orders', function (Blueprint $table) {
            $table->dropColumn(['orders_price']);
        });
    }
};
