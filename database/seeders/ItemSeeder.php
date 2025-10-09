<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get IDs for relationships
        $electronicsCategory = Category::where('name', 'Electronics')->first();
        $computerSubcategory = Subcategory::where('name', 'Computers')->first();
        $appleBrand = Brand::where('name', 'Apple')->first();
        $dellBrand = Brand::where('name', 'Dell')->first();
        $samsungBrand = Brand::where('name', 'Samsung')->first();
        
        if ($electronicsCategory && $computerSubcategory && $appleBrand) {
            // Create some electronic items
            $items = [
                [
                    'code' => 'MAC001',
                    'name' => 'MacBook Pro 16-inch',
                    'category_id' => $electronicsCategory->id,
                    'subcategory_id' => $computerSubcategory->id,
                    'brand_id' => $appleBrand->id,
                    'description' => 'High-performance laptop with M1 Pro chip',
                    'specifications' => json_encode([
                        'processor' => 'Apple M1 Pro',
                        'memory' => '16GB',
                        'storage' => '512GB SSD',
                        'display' => '16-inch Retina',
                        'os' => 'macOS Monterey'
                    ]),
                    'price' => 2499.99
                ],
                [
                    'code' => 'DELL001',
                    'name' => 'Dell XPS 13',
                    'category_id' => $electronicsCategory->id,
                    'subcategory_id' => $computerSubcategory->id,
                    'brand_id' => $dellBrand->id,
                    'description' => 'Compact and powerful laptop for professionals',
                    'specifications' => json_encode([
                        'processor' => 'Intel Core i7',
                        'memory' => '16GB',
                        'storage' => '1TB SSD',
                        'display' => '13.4-inch FHD+',
                        'os' => 'Windows 11'
                    ]),
                    'price' => 1299.99
                ],
                [
                    'code' => 'IPH001',
                    'name' => 'iPhone 15 Pro',
                    'category_id' => $electronicsCategory->id,
                    'subcategory_id' => Subcategory::where('name', 'Mobile Phones')->first()->id,
                    'brand_id' => $appleBrand->id,
                    'description' => 'Latest iPhone with titanium build',
                    'specifications' => json_encode([
                        'processor' => 'A17 Pro chip',
                        'display' => '6.1-inch Super Retina XDR',
                        'storage' => '256GB',
                        'camera' => 'Triple camera system',
                        'os' => 'iOS 17'
                    ]),
                    'price' => 999.99
                ],
                [
                    'code' => 'SAMS001',
                    'name' => 'Samsung Galaxy S23',
                    'category_id' => $electronicsCategory->id,
                    'subcategory_id' => Subcategory::where('name', 'Mobile Phones')->first()->id,
                    'brand_id' => $samsungBrand->id,
                    'description' => 'Flagship Android smartphone',
                    'specifications' => json_encode([
                        'processor' => 'Snapdragon 8 Gen 2',
                        'display' => '6.1-inch Dynamic AMOLED',
                        'storage' => '256GB',
                        'camera' => 'Triple camera system',
                        'os' => 'Android 13'
                    ]),
                    'price' => 799.99
                ]
            ];

            foreach ($items as $itemData) {
                Item::create($itemData);
            }
        }
        
        // Create furniture items
        $furnitureCategory = Category::where('name', 'Furniture')->first();
        $deskSubcategory = Subcategory::where('name', 'Desks')->first();
        $ikeaBrand = Brand::where('name', 'IKEA')->first();
        
        if ($furnitureCategory && $deskSubcategory && $ikeaBrand) {
            $furnitureItems = [
                [
                    'code' => 'IKEA001',
                    'name' => 'MICKE Desk',
                    'category_id' => $furnitureCategory->id,
                    'subcategory_id' => $deskSubcategory->id,
                    'brand_id' => $ikeaBrand->id,
                    'description' => 'Compact corner computer desk with cable management',
                    'specifications' => json_encode([
                        'material' => 'Particleboard',
                        'color' => 'White',
                        'dimensions' => '105x50x75 cm',
                        'assembly_required' => true
                    ]),
                    'price' => 199.99
                ]
            ];
            
            foreach ($furnitureItems as $itemData) {
                Item::create($itemData);
            }
        }
    }
}