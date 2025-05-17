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
        Schema::table('cart_items', function (Blueprint $table) {
            // Drop the foreign key constraint for product_id
            $table->dropForeign(['product_id']);
            
            // Add product_type column
            $table->string('product_type')->default('regular')->after('product_id');
            
            // Make product_id an unsigned bigInteger without foreign key constraint
            $table->unsignedBigInteger('product_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            // Remove the product_type column
            $table->dropColumn('product_type');
            
            // Re-add the foreign key constraint
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }
};
