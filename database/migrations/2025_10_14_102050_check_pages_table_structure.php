<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if pages table exists
        if (Schema::hasTable('pages')) {
            // Get table structure
            $columns = DB::select("SHOW COLUMNS FROM pages");
            
            // Print structure for debugging
            echo "Pages table structure:\n";
            foreach ($columns as $column) {
                echo "- {$column->Field}: {$column->Type}\n";
            }
            
            // Check if there are any pages
            $pageCount = DB::table('pages')->count();
            echo "\nNumber of pages: {$pageCount}\n";
            
            // If no pages exist, create a home page
            if ($pageCount === 0) {
                echo "\nCreating home page...\n";
                
                DB::table('pages')->insert([
                    'id' => 1, // Use integer ID since that's what the table expects
                    'title' => 'Home',
                    'slug' => 'home',
                    'content' => json_encode([
                        [
                            'id' => 'hero-section',
                            'type' => 'hero',
                            'content' => [
                                'title' => 'Welcome to Moimstone Dasan Indonesia',
                                'subtitle' => 'Your trusted partner for network connectivity solutions',
                                'image_url' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                                'primary_button_url' => '/products',
                                'primary_button_text' => 'Explore Products'
                            ],
                            'settings' => [
                                'colSpan' => 1,
                                'background' => 'bg-gradient-to-r from-blue-600 to-indigo-700'
                            ]
                        ],
                        [
                            'id' => 'features-section',
                            'type' => 'features',
                            'content' => [
                                'title' => 'Why Choose Us',
                                'features' => [
                                    [
                                        'icon' => 'Shield',
                                        'title' => 'Trusted Solutions',
                                        'description' => 'Reliable network equipment from leading manufacturers'
                                    ],
                                    [
                                        'icon' => 'Users',
                                        'title' => 'Expert Support',
                                        'description' => 'Professional technical assistance and consultation'
                                    ],
                                    [
                                        'icon' => 'Star',
                                        'title' => 'Quality Products',
                                        'description' => 'High-performance equipment for all your networking needs'
                                    ]
                                ]
                            ],
                            'settings' => [
                                'colSpan' => 1,
                                'layout' => 'cards'
                            ]
                        ]
                    ]),
                    'is_active' => 1,
                    'is_public' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                
                echo "Home page created successfully.\n";
            }
        } else {
            echo "Pages table does not exist.\n";
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is for checking only, no rollback needed
    }
};
