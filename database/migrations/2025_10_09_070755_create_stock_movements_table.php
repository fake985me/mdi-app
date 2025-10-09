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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->enum('type', ['masuk', 'keluar']); // 'masuk' for stock in, 'keluar' for stock out
            $table->integer('quantity');
            $table->string('reference_type')->nullable(); // 'pembelian', 'penjualan', 'peminjaman', 'pengembalian', etc.
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->date('date');
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
