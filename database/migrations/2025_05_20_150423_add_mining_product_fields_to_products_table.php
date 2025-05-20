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
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_mining_product')->default(false);
            $table->unsignedBigInteger('mining_product_id')->nullable();
            $table->foreign('mining_product_id')->references('id')->on('mining_products')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['mining_product_id']);
            $table->dropColumn('mining_product_id');
            $table->dropColumn('is_mining_product');
        });
    }
};
