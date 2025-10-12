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
        Schema::table('pages', function (Blueprint $table) {
            // Add columns for SEO and metadata
            $table->text('meta_description')->nullable()->after('slug');
            $table->string('meta_keywords')->nullable()->after('meta_description');
            $table->string('featured_image')->nullable()->after('meta_keywords');
            
            // Add columns for custom styling
            $table->json('custom_css')->nullable()->after('settings');
            $table->json('custom_js')->nullable()->after('custom_css');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['meta_description', 'meta_keywords', 'featured_image', 'custom_css', 'custom_js']);
        });
    }
};