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
        if (!Schema::hasTable('borrowing_items')) {
            Schema::create('borrowing_items', function (Blueprint $table) {
                $table->char('id', 36)->primary();
                $table->char('borrowing_id', 36);
                $table->char('product_id', 36);
                $table->integer('quantity');
                $table->decimal('unit_price', 10, 2);
                $table->decimal('total_amount', 10, 2);
                $table->timestamps();

                $table->foreign('borrowing_id')->references('id')->on('borrowings')->onDelete('cascade');
                $table->foreign('product_id')->references('id')->on('products');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowing_items');
    }
};
