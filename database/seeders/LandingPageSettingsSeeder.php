<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LandingPageSetting;
use Illuminate\Support\Str;

class LandingPageSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default landing page sections
        $sections = [
            [
                'section_name' => 'Hero Section',
                'section_type' => 'hero',
                'content' => [
                    'title' => 'Welcome to Our Store',
                    'subtitle' => 'Discover amazing products at great prices',
                    'cta_text' => 'Shop Now',
                    'cta_link' => '/catalog',
                    'image_url' => null
                ],
                'settings' => [
                    'background_color' => '#1e40af',
                    'text_color' => '#ffffff',
                    'height' => 'large',
                    'alignment' => 'center'
                ],
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'section_name' => 'Featured Products',
                'section_type' => 'products',
                'content' => [
                    'title' => 'Featured Products',
                    'subtitle' => 'Check out our most popular items',
                    'product_count' => 8,
                    'show_filters' => true
                ],
                'settings' => [
                    'columns' => 4,
                    'layout' => 'grid',
                    'show_rating' => true,
                    'show_price' => true
                ],
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'section_name' => 'Features Section',
                'section_type' => 'features',
                'content' => [
                    'title' => 'Why Choose Us',
                    'subtitle' => 'We provide the best experience for our customers',
                    'features' => [
                        [
                            'icon' => 'Package',
                            'title' => 'Fast Delivery',
                            'description' => 'Get your products quickly with our express delivery'
                        ],
                        [
                            'icon' => 'Shield',
                            'title' => 'Quality Guarantee',
                            'description' => 'All products come with quality guarantee'
                        ],
                        [
                            'icon' => 'CreditCard',
                            'title' => 'Secure Payment',
                            'description' => 'Your payments are secured with bank-level encryption'
                        ]
                    ]
                ],
                'settings' => [
                    'columns' => 3,
                    'layout' => 'cards',
                    'theme' => 'light'
                ],
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'section_name' => 'Testimonials',
                'section_type' => 'testimonials',
                'content' => [
                    'title' => 'What Our Customers Say',
                    'subtitle' => 'Hear from our satisfied customers',
                    'testimonials' => [
                        [
                            'name' => 'John Doe',
                            'position' => 'Customer',
                            'content' => 'Great service and amazing products. Will definitely order again!',
                            'rating' => 5
                        ],
                        [
                            'name' => 'Jane Smith',
                            'position' => 'Customer',
                            'content' => 'Fast shipping and excellent quality. Highly recommended!',
                            'rating' => 5
                        ]
                    ]
                ],
                'settings' => [
                    'columns' => 2,
                    'show_ratings' => true
                ],
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'section_name' => 'Call to Action',
                'section_type' => 'cta',
                'content' => [
                    'title' => 'Ready to get started?',
                    'subtitle' => 'Join thousands of satisfied customers today',
                    'cta_text' => 'Sign Up Now',
                    'cta_link' => '/register'
                ],
                'settings' => [
                    'background_color' => '#3b82f6',
                    'text_color' => '#ffffff',
                    'button_color' => '#ffffff',
                    'button_text_color' => '#3b82f6'
                ],
                'is_active' => true,
                'sort_order' => 5
            ]
        ];

        foreach ($sections as $section) {
            LandingPageSetting::create($section);
        }
    }
}