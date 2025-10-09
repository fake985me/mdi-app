<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subcategory;
use App\Models\Category;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create subcategories for other main categories
        
        // Furniture subcategories
        $furnitureCategory = Category::where('name', 'Furniture')->first();
        if ($furnitureCategory) {
            $furnitureSubcategories = [
                ['name' => 'Desks', 'category_id' => $furnitureCategory->id],
                ['name' => 'Chairs', 'category_id' => $furnitureCategory->id],
                ['name' => 'Tables', 'category_id' => $furnitureCategory->id],
                ['name' => 'Cabinets', 'category_id' => $furnitureCategory->id],
            ];
            
            foreach ($furnitureSubcategories as $subcategory) {
                Subcategory::create($subcategory);
            }
        }
        
        // Office Supplies subcategories
        $officeCategory = Category::where('name', 'Office Supplies')->first();
        if ($officeCategory) {
            $officeSubcategories = [
                ['name' => 'Stationery', 'category_id' => $officeCategory->id],
                ['name' => 'Filing Supplies', 'category_id' => $officeCategory->id],
                ['name' => 'Desk Accessories', 'category_id' => $officeCategory->id],
                ['name' => 'Presentation Supplies', 'category_id' => $officeCategory->id],
            ];
            
            foreach ($officeSubcategories as $subcategory) {
                Subcategory::create($subcategory);
            }
        }
        
        // Machinery subcategories
        $machineryCategory = Category::where('name', 'Machinery')->first();
        if ($machineryCategory) {
            $machinerySubcategories = [
                ['name' => 'Industrial Equipment', 'category_id' => $machineryCategory->id],
                ['name' => 'Power Tools', 'category_id' => $machineryCategory->id],
                ['name' => 'Construction Equipment', 'category_id' => $machineryCategory->id],
                ['name' => 'Agricultural Machinery', 'category_id' => $machineryCategory->id],
            ];
            
            foreach ($machinerySubcategories as $subcategory) {
                Subcategory::create($subcategory);
            }
        }
        
        // Clothing subcategories
        $clothingCategory = Category::where('name', 'Clothing')->first();
        if ($clothingCategory) {
            $clothingSubcategories = [
                ['name' => 'Men\'s Clothing', 'category_id' => $clothingCategory->id],
                ['name' => 'Women\'s Clothing', 'category_id' => $clothingCategory->id],
                ['name' => 'Children\'s Clothing', 'category_id' => $clothingCategory->id],
                ['name' => 'Accessories', 'category_id' => $clothingCategory->id],
            ];
            
            foreach ($clothingSubcategories as $subcategory) {
                Subcategory::create($subcategory);
            }
        }
    }
}