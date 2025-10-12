<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use Illuminate\Support\Str;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample pages
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'meta_description' => 'Learn more about our company and mission',
                'content' => [
                    [
                        'id' => 'section-1',
                        'type' => 'hero',
                        'content' => [
                            'title' => 'About Our Company',
                            'subtitle' => 'Discover our story, mission, and values',
                            'image_url' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                            'primary_button_text' => 'Our Team',
                            'primary_button_url' => '#team'
                        ],
                        'settings' => [
                            'colSpan' => 1,
                            'background' => 'bg-gradient-to-r from-blue-600 to-indigo-700'
                        ]
                    ],
                    [
                        'id' => 'section-2',
                        'type' => 'content_with_image',
                        'content' => [
                            'title' => 'Our Story',
                            'content' => '<p>Founded in 2010, our company began with a simple vision: to revolutionize the way businesses manage their operations. What started as a small team in a garage has grown into a thriving enterprise serving clients worldwide.</p><p>Today, we pride ourselves on innovation, quality, and exceptional customer service. Our commitment to excellence drives us to continuously improve and expand our offerings.</p>',
                            'image_url' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80'
                        ],
                        'settings' => [
                            'colSpan' => 1,
                            'image_position' => 'right'
                        ]
                    ]
                ],
                'settings' => [
                    'layout' => 'full-width'
                ],
                'is_active' => true
            ],
            [
                'title' => 'Services',
                'slug' => 'services',
                'meta_description' => 'Explore our comprehensive range of services',
                'content' => [
                    [
                        'id' => 'section-1',
                        'type' => 'hero',
                        'content' => [
                            'title' => 'Our Services',
                            'subtitle' => 'Comprehensive solutions tailored to your business needs',
                            'image_url' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                            'primary_button_text' => 'Get Started',
                            'primary_button_url' => '/contact'
                        ],
                        'settings' => [
                            'colSpan' => 1,
                            'background' => 'bg-gradient-to-r from-purple-600 to-pink-600'
                        ]
                    ],
                    [
                        'id' => 'section-2',
                        'type' => 'features',
                        'content' => [
                            'title' => 'What We Offer',
                            'features' => [
                                [
                                    'title' => 'Consulting',
                                    'description' => 'Expert guidance to optimize your business processes',
                                    'icon' => 'Users'
                                ],
                                [
                                    'title' => 'Development',
                                    'description' => 'Custom software solutions built to your specifications',
                                    'icon' => 'Code'
                                ],
                                [
                                    'title' => 'Support',
                                    'description' => '24/7 technical support and maintenance',
                                    'icon' => 'Shield'
                                ]
                            ]
                        ],
                        'settings' => [
                            'colSpan' => 1,
                            'layout' => 'cards'
                        ]
                    ]
                ],
                'settings' => [
                    'layout' => 'full-width'
                ],
                'is_active' => true
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact',
                'meta_description' => 'Get in touch with our team for inquiries and support',
                'content' => [
                    [
                        'id' => 'section-1',
                        'type' => 'hero',
                        'content' => [
                            'title' => 'Get In Touch',
                            'subtitle' => 'We\'d love to hear from you. Reach out to our team.',
                            'image_url' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                            'primary_button_text' => 'Call Us',
                            'primary_button_url' => 'tel:+1234567890'
                        ],
                        'settings' => [
                            'colSpan' => 1,
                            'background' => 'bg-gradient-to-r from-green-600 to-teal-600'
                        ]
                    ],
                    [
                        'id' => 'section-2',
                        'type' => 'grid_layout',
                        'content' => [
                            'title' => 'Contact Information',
                            'items' => [
                                [
                                    'title' => 'Address',
                                    'description' => '123 Business Street, Suite 100, City, State 12345'
                                ],
                                [
                                    'title' => 'Phone',
                                    'description' => '+1 (234) 567-890'
                                ],
                                [
                                    'title' => 'Email',
                                    'description' => 'info@company.com'
                                ],
                                [
                                    'title' => 'Hours',
                                    'description' => 'Monday-Friday: 9AM-5PM'
                                ]
                            ]
                        ],
                        'settings' => [
                            'colSpan' => 1,
                            'columns' => 2
                        ]
                    ]
                ],
                'settings' => [
                    'layout' => 'full-width'
                ],
                'is_active' => true
            ]
        ];

        foreach ($pages as $pageData) {
            Page::updateOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );
        }
    }
}