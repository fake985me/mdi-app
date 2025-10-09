<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

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
                'description' => 'Electronic devices and gadgets'
            ],
            [
                'name' => 'Furniture',
                'description' => 'Home and office furniture'
            ],
            [
                'name' => 'Office Supplies',
                'description' => 'Stationery and office equipment'
            ],
            [
                'name' => 'Machinery',
                'description' => 'Industrial and commercial machinery'
            ],
            [
                'name' => 'Clothing',
                'description' => 'Apparel and accessories'
            ]
        ];

        foreach ($categories as $categoryData) {
            Category::create([
                'name' => $categoryData['name'],
                'description' => $categoryData['description'],
            ]);
        }
        
        // Create some subcategories under Electronics
        $electronicsCategory = Category::where('name', 'Electronics')->first();
        
        if ($electronicsCategory) {
            $electronicsSubcategories = [
                ['name' => 'Computers', 'category_id' => $electronicsCategory->id],
                ['name' => 'Mobile Phones', 'category_id' => $electronicsCategory->id],
                ['name' => 'Audio Equipment', 'category_id' => $electronicsCategory->id],
                ['name' => 'TVs & Home Theater', 'category_id' => $electronicsCategory->id],
            ];
            
            foreach ($electronicsSubcategories as $subcategory) {
                \App\Models\Subcategory::create($subcategory);
            }
        }
    }
}