<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices and accessories'
            ],
            [
                'name' => 'Furniture',
                'description' => 'Home and office furniture'
            ],
            [
                'name' => 'Clothing',
                'description' => 'Apparel and accessories'
            ],
            [
                'name' => 'Books',
                'description' => 'Educational and recreational books'
            ],
            [
                'name' => 'Sports',
                'description' => 'Sports equipment and accessories'
            ]
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
