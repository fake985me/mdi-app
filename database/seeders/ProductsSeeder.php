<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Str;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories and subcategories based on schema
        $electronics = Category::where('name', 'Electronics')->first();
        $officeSupplies = Category::where('name', 'Office Supplies')->first();
        $toolsEquipment = Category::where('name', 'Tools & Equipment')->first();
        $furniture = Category::where('name', 'Furniture')->first();
        $safetyEquipment = Category::where('name', 'Safety Equipment')->first();
        
        $computers = Subcategory::where('name', 'Computers')->first();
        $mobileDevices = Subcategory::where('name', 'Mobile Devices')->first();
        $audioEquipment = Subcategory::where('name', 'Audio Equipment')->first();
        $stationery = Subcategory::where('name', 'Stationery')->first();
        $printing = Subcategory::where('name', 'Printing')->first();
        $handTools = Subcategory::where('name', 'Hand Tools')->first();
        $powerTools = Subcategory::where('name', 'Power Tools')->first();
        $desks = Subcategory::where('name', 'Desks')->first();
        $chairs = Subcategory::where('name', 'Chairs')->first();
        $protectiveGear = Subcategory::where('name', 'Protective Gear')->first();
        
        // Sample products based on the schema
        $products = [
            [
                'name' => 'Dell OptiPlex 7090',
                'description' => 'High-performance desktop computer for office use',
                'sku' => 'DELL-7090-001',
                'category_id' => $electronics->id,
                'subcategory_id' => $computers->id,
                'price' => 899.99,
                'cost_price' => 650.00,
                'current_stock' => 25,
                'minimum_stock' => 5,
                'maximum_stock' => 50,
                'image_url' => 'https://images.pexels.com/photos/2148217/pexels-photo-2148217.jpeg',
            ],
            
            [
                'name' => 'iPhone 14 Pro',
                'description' => 'Latest Apple smartphone with advanced camera system',
                'sku' => 'APPLE-IP14P-001',
                'category_id' => $electronics->id,
                'subcategory_id' => $mobileDevices->id,
                'price' => 1099.99,
                'cost_price' => 800.00,
                'current_stock' => 15,
                'minimum_stock' => 3,
                'maximum_stock' => 30,
                'image_url' => 'https://images.pexels.com/photos/788946/pexels-photo-788946.jpeg',
            ],
            
            [
                'name' => 'Sony WH-1000XM4',
                'description' => 'Wireless noise-canceling headphones',
                'sku' => 'SONY-WH1000-001',
                'category_id' => $electronics->id,
                'subcategory_id' => $audioEquipment->id,
                'price' => 349.99,
                'cost_price' => 250.00,
                'current_stock' => 40,
                'minimum_stock' => 10,
                'maximum_stock' => 80,
                'image_url' => 'https://images.pexels.com/photos/3394650/pexels-photo-3394650.jpeg',
            ],
            
            [
                'name' => 'HP LaserJet Pro',
                'description' => 'Professional laser printer for office use',
                'sku' => 'HP-LJ-PRO-001',
                'category_id' => $officeSupplies->id,
                'subcategory_id' => $printing->id,
                'price' => 299.99,
                'cost_price' => 200.00,
                'current_stock' => 12,
                'minimum_stock' => 2,
                'maximum_stock' => 25,
                'image_url' => 'https://images.pexels.com/photos/4226140/pexels-photo-4226140.jpeg',
            ],
            
            [
                'name' => 'Ergonomic Office Chair',
                'description' => 'Comfortable ergonomic chair with lumbar support',
                'sku' => 'CHAIR-ERG-001',
                'category_id' => $furniture->id,
                'subcategory_id' => $chairs->id,
                'price' => 249.99,
                'cost_price' => 150.00,
                'current_stock' => 30,
                'minimum_stock' => 5,
                'maximum_stock' => 60,
                'image_url' => 'https://images.pexels.com/photos/586344/pexels-photo-586344.jpeg',
            ],
            
            [
                'name' => 'DeWalt Cordless Drill',
                'description' => 'Professional cordless drill with battery pack',
                'sku' => 'DEWALT-CD-001',
                'category_id' => $toolsEquipment->id,
                'subcategory_id' => $powerTools->id,
                'price' => 179.99,
                'cost_price' => 120.00,
                'current_stock' => 22,
                'minimum_stock' => 5,
                'maximum_stock' => 40,
                'image_url' => 'https://images.pexels.com/photos/1249611/pexels-photo-1249611.jpeg',
            ],
            
            [
                'name' => 'Safety Helmet',
                'description' => 'Industrial safety helmet with adjustable strap',
                'sku' => 'HELMET-SF-001',
                'category_id' => $safetyEquipment->id,
                'subcategory_id' => $protectiveGear->id,
                'price' => 29.99,
                'cost_price' => 18.00,
                'current_stock' => 50,
                'minimum_stock' => 10,
                'maximum_stock' => 100,
                'image_url' => 'https://images.pexels.com/photos/1117452/pexels-photo-1117452.jpeg',
            ],
            
            [
                'name' => 'Standing Desk',
                'description' => 'Height-adjustable standing desk',
                'sku' => 'DESK-STAND-001',
                'category_id' => $furniture->id,
                'subcategory_id' => $desks->id,
                'price' => 599.99,
                'cost_price' => 400.00,
                'current_stock' => 8,
                'minimum_stock' => 2,
                'maximum_stock' => 20,
                'image_url' => 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg',
            ],
            
            [
                'name' => 'Wireless Mouse',
                'description' => 'Ergonomic wireless optical mouse',
                'sku' => 'MOUSE-WL-001',
                'category_id' => $electronics->id,
                'subcategory_id' => $computers->id,
                'price' => 39.99,
                'cost_price' => 25.00,
                'current_stock' => 75,
                'minimum_stock' => 15,
                'maximum_stock' => 150,
                'image_url' => 'https://images.pexels.com/photos/2115256/pexels-photo-2115256.jpeg',
            ],
            
            [
                'name' => 'Notebook Set',
                'description' => 'Professional notebook set with pens',
                'sku' => 'NOTEBOOK-SET-001',
                'category_id' => $officeSupplies->id,
                'subcategory_id' => $stationery->id,
                'price' => 19.99,
                'cost_price' => 12.00,
                'current_stock' => 100,
                'minimum_stock' => 20,
                'maximum_stock' => 200,
                'image_url' => 'https://images.pexels.com/photos/1925536/pexels-photo-1925536.jpeg',
            ],
            
            [
                'name' => 'Bluetooth Speaker',
                'description' => 'Portable wireless Bluetooth speaker',
                'sku' => 'SPEAKER-BT-001',
                'category_id' => $electronics->id,
                'subcategory_id' => $audioEquipment->id,
                'price' => 89.99,
                'cost_price' => 60.00,
                'current_stock' => 35,
                'minimum_stock' => 8,
                'maximum_stock' => 70,
                'image_url' => 'https://images.pexels.com/photos/1649771/pexels-photo-1649771.jpeg',
            ],
            
            [
                'name' => 'Tool Set',
                'description' => 'Complete hand tool set with carrying case',
                'sku' => 'TOOLSET-HAND-001',
                'category_id' => $toolsEquipment->id,
                'subcategory_id' => $handTools->id,
                'price' => 129.99,
                'cost_price' => 85.00,
                'current_stock' => 18,
                'minimum_stock' => 3,
                'maximum_stock' => 35,
                'image_url' => 'https://images.pexels.com/photos/1249611/pexels-photo-1249611.jpeg',
            ],
        ];
        
        foreach ($products as $productData) {
            $productData['status'] = true; // Adding the missing status field
            Product::firstOrCreate(
                ['sku' => $productData['sku']],
                $productData
            );
        }
    }
}