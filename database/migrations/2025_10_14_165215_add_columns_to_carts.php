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
        Schema::table('carts', function (Blueprint $table) {
            $table->unsignedBigInteger('offer_id')->nullable()->after('user_id');
            $table->foreign('offer_id')->on('offers')->references('id');
            $table->string('offer_type')->nullable()->after('offer_id');
            $table->string('offer_value')->nullable()->after('offer_type');
            $table->string('offer_discount')->nullable()->after('offer_value');
            $table->double('final_price')->nullable()->after('offer_discount')->default(0.0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign('offer_id');
            $table->dropColumn(['offer_id', 'offer_type', 'offer_value', 'offer_discount', 'final_price']);
        });
    }
};
