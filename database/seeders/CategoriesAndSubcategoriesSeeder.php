<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Subcategory;

class CategoriesAndSubcategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create main categories based on the schema if they don't exist
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices and components'
            ],
            [
                'name' => 'Office Supplies',
                'description' => 'Office equipment and stationery'
            ],
            [
                'name' => 'Tools & Equipment',
                'description' => 'Industrial and workshop tools'
            ],
            [
                'name' => 'Furniture',
                'description' => 'Office and warehouse furniture'
            ],
            [
                'name' => 'Safety Equipment',
                'description' => 'Personal protective equipment'
            ],
        ];

        foreach ($categories as $categoryData) {
            $category = Category::firstOrCreate(
                ['name' => $categoryData['name']],
                $categoryData
            );
            
            // Create subcategories based on the category if they don't exist
            $this->createSubcategoriesForCategory($category);
        }
    }

    private function createSubcategoriesForCategory($category)
    {
        $subcategories = [];
        
        switch ($category->name) {
            case 'Electronics':
                $subcategories = [
                    ['name' => 'Computers', 'description' => 'Desktop and laptop computers'],
                    ['name' => 'Mobile Devices', 'description' => 'Smartphones and tablets'],
                    ['name' => 'Audio Equipment', 'description' => 'Speakers and headphones'],
                ];
                break;
                
            case 'Office Supplies':
                $subcategories = [
                    ['name' => 'Stationery', 'description' => 'Pens, papers, and writing materials'],
                    ['name' => 'Printing', 'description' => 'Printers and printing supplies'],
                ];
                break;
                
            case 'Tools & Equipment':
                $subcategories = [
                    ['name' => 'Hand Tools', 'description' => 'Manual tools and equipment'],
                    ['name' => 'Power Tools', 'description' => 'Electric and battery tools'],
                ];
                break;
                
            case 'Furniture':
                $subcategories = [
                    ['name' => 'Desks', 'description' => 'Office and work desks'],
                    ['name' => 'Chairs', 'description' => 'Office and ergonomic chairs'],
                ];
                break;
                
            case 'Safety Equipment':
                $subcategories = [
                    ['name' => 'Protective Gear', 'description' => 'Helmets, gloves, and safety wear'],
                ];
                break;
        }

        foreach ($subcategories as $subcategoryData) {
            Subcategory::create([
                'name' => $subcategoryData['name'],
                'description' => $subcategoryData['description'],
                'category_id' => $category->id,
            ]);
        }
    }
}