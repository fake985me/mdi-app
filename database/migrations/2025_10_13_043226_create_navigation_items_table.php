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
        Schema::create('navigation_items', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama tampilan untuk navigasi
            $table->string('path'); // Path absolute untuk navigasi
            $table->string('slug')->unique(); // Slug untuk URL
            $table->integer('parent_id')->nullable(); // Untuk navigasi bersarang
            $table->integer('sort_order')->default(0); // Urutan tampil
            $table->boolean('is_active')->default(true); // Status aktif/nonaktif
            $table->boolean('is_public')->default(true); // Apakah tampil untuk publik
            $table->json('metadata')->nullable(); // Kolom untuk menyimpan data tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navigation_items');
    }
};
