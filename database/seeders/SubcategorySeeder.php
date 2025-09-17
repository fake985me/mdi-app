<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $electronics = Category::where('name', 'Electronics')->first();
        $furniture = Category::where('name', 'Furniture')->first();
        $clothing = Category::where('name', 'Clothing')->first();
        $books = Category::where('name', 'Books')->first();
        $sports = Category::where('name', 'Sports')->first();

        $subcategories = [
            // Electronics subcategories
            [
                'name' => 'Smartphones',
                'description' => 'Mobile phones and smartphones',
                'category_id' => $electronics->id
            ],
            [
                'name' => 'Laptops',
                'description' => 'Notebooks and laptops',
                'category_id' => $electronics->id
            ],
            [
                'name' => 'Accessories',
                'description' => 'Electronic accessories',
                'category_id' => $electronics->id
            ],

            // Furniture subcategories
            [
                'name' => 'Living Room',
                'description' => 'Living room furniture',
                'category_id' => $furniture->id
            ],
            [
                'name' => 'Bedroom',
                'description' => 'Bedroom furniture',
                'category_id' => $furniture->id
            ],
            [
                'name' => 'Office',
                'description' => 'Office furniture',
                'category_id' => $furniture->id
            ],

            // Clothing subcategories
            [
                'name' => 'Men',
                'description' => 'Men\'s clothing',
                'category_id' => $clothing->id
            ],
            [
                'name' => 'Women',
                'description' => 'Women\'s clothing',
                'category_id' => $clothing->id
            ],
            [
                'name' => 'Children',
                'description' => 'Children\'s clothing',
                'category_id' => $clothing->id
            ],

            // Books subcategories
            [
                'name' => 'Fiction',
                'description' => 'Fiction books',
                'category_id' => $books->id
            ],
            [
                'name' => 'Non-Fiction',
                'description' => 'Non-fiction books',
                'category_id' => $books->id
            ],
            [
                'name' => 'Educational',
                'description' => 'Educational books',
                'category_id' => $books->id
            ],

            // Sports subcategories
            [
                'name' => 'Indoor',
                'description' => 'Indoor sports equipment',
                'category_id' => $sports->id
            ],
            [
                'name' => 'Outdoor',
                'description' => 'Outdoor sports equipment',
                'category_id' => $sports->id
            ],
            [
                'name' => 'Fitness',
                'description' => 'Fitness equipment',
                'category_id' => $sports->id
            ]
        ];

        foreach ($subcategories as $subcategory) {
            Subcategory::updateOrCreate(
                ['name' => $subcategory['name'], 'category_id' => $subcategory['category_id']],
                $subcategory
            );
        }
    }
}
