<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a landing page template
        \App\Models\Template::create([
            'name' => 'Modern Business Landing',
            'slug' => 'modern-business-landing',
            'description' => 'A modern business landing page with hero section, features, testimonials, and call to action',
            'category' => 'landing',
            'content' => [
                [
                    'id' => 'hero-section-1',
                    'type' => 'hero',
                    'content' => [
                        'title' => 'Welcome to Our Business',
                        'subtitle' => 'We provide the best solutions for your needs',
                        'image_url' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                        'primary_button_text' => 'Get Started',
                        'primary_button_url' => '/contact'
                    ],
                    'settings' => [
                        'colSpan' => 1,
                        'background' => 'bg-gradient-to-r from-blue-600 to-indigo-700'
                    ]
                ],
                [
                    'id' => 'features-section-1',
                    'type' => 'features',
                    'content' => [
                        'title' => 'Why Choose Us',
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
                        'colSpan' => 1,
                        'layout' => 'cards',
                        'columns' => 3
                    ]
                ],
                [
                    'id' => 'cta-section-1',
                    'type' => 'cta',
                    'content' => [
                        'title' => 'Ready to get started?',
                        'subtitle' => 'Join thousands of satisfied customers today',
                        'cta_text' => 'Sign Up Now',
                        'cta_link' => '/register'
                    ],
                    'settings' => [
                        'colSpan' => 1,
                        'background_color' => '#3b82f6',
                        'text_color' => '#ffffff',
                        'button_color' => '#ffffff',
                        'button_text_color' => '#3b82f6'
                    ]
                ]
            ],
            'is_active' => true,
            'sort_order' => 1
        ]);

        // Create a blog post template
        \App\Models\Template::create([
            'name' => 'Simple Blog Post',
            'slug' => 'simple-blog-post',
            'description' => 'A clean template for blog posts with main content and sidebar',
            'category' => 'blog',
            'content' => [
                [
                    'id' => 'hero-section-2',
                    'type' => 'hero',
                    'content' => [
                        'title' => 'Blog Post Title',
                        'subtitle' => 'Published on [Date] by [Author]',
                    ],
                    'settings' => [
                        'colSpan' => 1,
                        'background' => 'bg-gray-100'
                    ]
                ],
                [
                    'id' => 'content-section-1',
                    'type' => 'text_block',
                    'content' => [
                        'title' => 'Main Content',
                        'content' => '<p>This is where your blog post content goes. You can add text, images, and other elements to create engaging content for your readers.</p><p>The template provides a clean and professional layout that focuses on readability and user experience.</p>'
                    ],
                    'settings' => [
                        'colSpan' => 1
                    ]
                ]
            ],
            'is_active' => true,
            'sort_order' => 2
        ]);

        // Create an e-commerce template
        \App\Models\Template::create([
            'name' => 'Product Showcase',
            'slug' => 'product-showcase',
            'description' => 'Template for showcasing products with grid layout and features',
            'category' => 'e-commerce',
            'content' => [
                [
                    'id' => 'hero-section-3',
                    'type' => 'hero',
                    'content' => [
                        'title' => 'Featured Products',
                        'subtitle' => 'Discover our latest and greatest products',
                        'primary_button_text' => 'Shop Now',
                        'primary_button_url' => '/products'
                    ],
                    'settings' => [
                        'colSpan' => 1,
                        'background' => 'bg-gradient-to-r from-green-500 to-teal-600'
                    ]
                ],
                [
                    'id' => 'grid-section-1',
                    'type' => 'grid',
                    'content' => [
                        'grid_title' => 'Our Products',
                        'columns' => 3,
                        'grid_items' => [
                            [
                                'title' => 'Product 1',
                                'description' => 'High quality product with excellent features',
                                'image_url' => 'https://images.unsplash.com/photo-1546868871-7041f2a55e12?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80'
                            ],
                            [
                                'title' => 'Product 2',
                                'description' => 'Affordable option with great value',
                                'image_url' => 'https://images.unsplash.com/photo-1554744512-d6c603f2b753?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80'
                            ],
                            [
                                'title' => 'Product 3',
                                'description' => 'Premium choice for professionals',
                                'image_url' => 'https://images.unsplash.com/photo-1585155770447-2f66e2a397b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80'
                            ]
                        ]
                    ],
                    'settings' => [
                        'colSpan' => 1,
                        'layout' => 'card'
                    ]
                ]
            ],
            'is_active' => true,
            'sort_order' => 3
        ]);
    }
}
