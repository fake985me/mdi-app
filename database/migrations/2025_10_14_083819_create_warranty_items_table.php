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
        // Only create the table if it doesn't already exist
        if (!Schema::hasTable('warranty_items')) {
            Schema::create('warranty_items', function (Blueprint $table) {
                $table->char('id', 36)->primary();
                $table->char('warranty_id', 36);
                $table->char('product_id', 36);
                $table->integer('quantity');
                $table->decimal('unit_price', 10, 2);
                $table->decimal('total_amount', 10, 2);
                $table->timestamps();

                $table->foreign('warranty_id')->references('id')->on('warranties')->onDelete('cascade');
                $table->foreign('product_id')->references('id')->on('products');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warranty_items');
    }
};
