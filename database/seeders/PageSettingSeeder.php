<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSetting;

class PageSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key_name' => 'navbar_title',
                'value' => 'Warehouse & Finance Management',
                'type' => 'text'
            ],
            [
                'key_name' => 'hero_title',
                'value' => 'Welcome to Our Warehouse & Finance System',
                'type' => 'text'
            ],
            [
                'key_name' => 'hero_description',
                'value' => 'Manage your inventory and finances efficiently with our comprehensive platform',
                'type' => 'text'
            ],
            [
                'key_name' => 'features_title',
                'value' => 'Our Key Features',
                'type' => 'text'
            ],
            [
                'key_name' => 'features_description',
                'value' => 'We provide the best tools for warehouse and finance management.',
                'type' => 'text'
            ],
            [
                'key_name' => 'feature1_title',
                'value' => 'Real-time Inventory',
                'type' => 'text'
            ],
            [
                'key_name' => 'feature1_description',
                'value' => 'Track all your inventory in real-time with our intuitive dashboard.',
                'type' => 'text'
            ],
            [
                'key_name' => 'feature2_title',
                'value' => 'Financial Analytics',
                'type' => 'text'
            ],
            [
                'key_name' => 'feature2_description',
                'value' => 'Monitor your finances with detailed reports and analytics.',
                'type' => 'text'
            ],
            [
                'key_name' => 'feature3_title',
                'value' => 'User-friendly Interface',
                'type' => 'text'
            ],
            [
                'key_name' => 'feature3_description',
                'value' => 'Our platform is designed with the user in mind for maximum efficiency.',
                'type' => 'text'
            ],
            [
                'key_name' => 'feature4_title',
                'value' => 'Security',
                'type' => 'text'
            ],
            [
                'key_name' => 'feature4_description',
                'value' => 'Your data is protected with enterprise-grade security features.',
                'type' => 'text'
            ],
            [
                'key_name' => 'products_title',
                'value' => 'Featured Products',
                'type' => 'text'
            ],
            [
                'key_name' => 'products_description',
                'value' => 'Check out our featured products below.',
                'type' => 'text'
            ],
            [
                'key_name' => 'company_name',
                'value' => 'Warehouse & Finance Solutions Inc.',
                'type' => 'text'
            ]
        ];

        foreach ($settings as $setting) {
            PageSetting::updateOrCreate(
                ['key_name' => $setting['key_name']],
                $setting
            );
        }
    }
}