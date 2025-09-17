<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WebSetting;

class WebSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WebSetting::create([
            'site_name' => 'Inventory Management System',
            'site_title' => 'Inventory Management System',
            'site_description' => 'Efficient inventory and finance management solution',
            'home_hero_title' => 'Welcome to Our Inventory Management System',
            'home_hero_description' => 'Efficiently manage your inventory, track stock levels, and monitor sales with our comprehensive solution.',
            'home_features' => [
                [
                    'title' => 'Inventory Tracking',
                    'description' => 'Keep track of all your products with real-time inventory updates and alerts.',
                    'icon' => 'fas fa-boxes'
                ],
                [
                    'title' => 'Sales Analytics',
                    'description' => 'Monitor your sales performance with detailed reports and insightful charts.',
                    'icon' => 'fas fa-chart-line'
                ],
                [
                    'title' => 'Stock Movements',
                    'description' => 'Track all stock movements including purchases, sales, and transfers.',
                    'icon' => 'fas fa-sync-alt'
                ]
            ],
            'footer_text' => '© 2025 Inventory Management System. All rights reserved.',
            'social_links' => [
                'facebook' => '#',
                'twitter' => '#',
                'instagram' => '#',
                'linkedin' => '#'
            ],
            'primary_color' => '#3b82f6',
            'secondary_color' => '#10b981'
        ]);
    }
}
