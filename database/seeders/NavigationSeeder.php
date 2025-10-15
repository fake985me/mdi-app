<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Date;

class NavigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create navigation items if they don't exist
        $navigationItems = [
            [
                'name' => 'Home',
                'path' => '/',
                'slug' => 'home',
                'parent_id' => null,
                'sort_order' => 0,
                'is_active' => true,
                'is_public' => true,
                'metadata' => json_encode([
                    'icon' => 'Home',
                    'description' => 'Homepage'
                ])
            ],
            [
                'name' => 'Products',
                'path' => '/product',
                'slug' => 'products',
                'parent_id' => null,
                'sort_order' => 1,
                'is_active' => true,
                'is_public' => true,
                'metadata' => json_encode([
                    'icon' => 'Package',
                    'description' => 'Browse our product catalog'
                ])
            ],
            [
                'name' => 'Solutions',
                'path' => '/solutions',
                'slug' => 'solutions',
                'parent_id' => null,
                'sort_order' => 2,
                'is_active' => true,
                'is_public' => true,
                'metadata' => json_encode([
                    'icon' => 'Lightbulb',
                    'description' => 'Explore our solutions'
                ])
            ],
            [
                'name' => 'Projects',
                'path' => '/projects',
                'slug' => 'projects',
                'parent_id' => null,
                'sort_order' => 3,
                'is_active' => true,
                'is_public' => true,
                'metadata' => json_encode([
                    'icon' => 'Briefcase',
                    'description' => 'View our completed projects'
                ])
            ],
            [
                'name' => 'Contact',
                'path' => '/contact',
                'slug' => 'contact',
                'parent_id' => null,
                'sort_order' => 4,
                'is_active' => true,
                'is_public' => true,
                'metadata' => json_encode([
                    'icon' => 'Phone',
                    'description' => 'Get in touch with us'
                ])
            ]
        ];

        foreach ($navigationItems as $item) {
            // Check if item already exists
            if (!DB::table('navigation_items')->where('slug', $item['slug'])->exists()) {
                DB::table('navigation_items')->insert(array_merge($item, [
                    'created_at' => Date::now(),
                    'updated_at' => Date::now()
                ]));
            }
        }
    }
}