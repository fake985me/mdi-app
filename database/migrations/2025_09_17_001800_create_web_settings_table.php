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
        Schema::create('web_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('Inventory Management System');
            $table->string('site_title')->nullable();
            $table->text('site_description')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('favicon_path')->nullable();
            $table->string('home_hero_title')->default('Welcome to Our Inventory Management System');
            $table->text('home_hero_description')->nullable();
            $table->string('home_hero_image_path')->nullable();
            $table->json('home_features')->nullable();
            $table->text('footer_text')->nullable();
            $table->json('social_links')->nullable();
            $table->string('primary_color')->default('#3b82f6'); // blue-500
            $table->string('secondary_color')->default('#10b981'); // emerald-500
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_settings');
    }
};
