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
        Schema::dropIfExists('purchase_items'); // Remove the default one
        
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('purchase_id', 36);
            $table->char('product_id', 36);
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();

            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products');
        });
        
        // Create sale_items table as well
        Schema::dropIfExists('sale_items');
        Schema::create('sale_items', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('sale_id', 36);
            $table->char('product_id', 36);
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();

            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_items');
        Schema::dropIfExists('purchase_items');
    }
};
