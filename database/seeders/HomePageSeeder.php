<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Date;

class HomePageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if home page already exists
        if (!DB::table('pages')->where('slug', 'home')->exists()) {
            // Create a home page
            DB::table('pages')->insert([
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
                'created_at' => Date::now(),
                'updated_at' => Date::now()
            ]);
        }
    }
}