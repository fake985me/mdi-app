<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing categories and subcategories
        $electronics = \App\Models\Category::where('name', 'Electronics')->first();
        $officeSupplies = \App\Models\Category::where('name', 'Office Supplies')->first();
        $toolsEquipment = \App\Models\Category::where('name', 'Tools & Equipment')->first();
        $furniture = \App\Models\Category::where('name', 'Furniture')->first();
        $safetyEquipment = \App\Models\Category::where('name', 'Safety Equipment')->first();
        
        $computers = \App\Models\Subcategory::where('name', 'Computers')->first();
        $mobileDevices = \App\Models\Subcategory::where('name', 'Mobile Devices')->first();
        $audioEquipment = \App\Models\Subcategory::where('name', 'Audio Equipment')->first();
        $stationery = \App\Models\Subcategory::where('name', 'Stationery')->first();
        $printing = \App\Models\Subcategory::where('name', 'Printing')->first();
        $handTools = \App\Models\Subcategory::where('name', 'Hand Tools')->first();
        $powerTools = \App\Models\Subcategory::where('name', 'Power Tools')->first();
        $desks = \App\Models\Subcategory::where('name', 'Desks')->first();
        $chairs = \App\Models\Subcategory::where('name', 'Chairs')->first();
        $protectiveGear = \App\Models\Subcategory::where('name', 'Protective Gear')->first();

        // Electronics products with beautiful images
        $electronicsProducts = [
            [
                'name' => 'MacBook Pro 16-inch M3 Max',
                'description' => 'Professional laptop with M3 Max chip, 12-core CPU, 18-core GPU, 36GB unified memory, 1TB SSD storage',
                'sku' => 'MAC-PRO-M3-001',
                'category_id' => $electronics->id,
                'subcategory_id' => $computers->id,
                'price' => 3499.99,
                'cost_price' => 2999.99,
                'current_stock' => 15,
                'minimum_stock' => 5,
                'maximum_stock' => 50,
                'image_url' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            ],
            [
                'name' => 'iPhone 15 Pro Max 256GB',
                'description' => 'Latest iPhone with titanium design, 48MP camera system, A17 Pro chip, and Action Button',
                'sku' => 'IPH-15PM-001',
                'category_id' => $electronics->id,
                'subcategory_id' => $mobileDevices->id,
                'price' => 1199.99,
                'cost_price' => 1049.99,
                'current_stock' => 25,
                'minimum_stock' => 8,
                'maximum_stock' => 100,
                'image_url' => 'https://images.unsplash.com/photo-1704349357562-c6a2a7dee420?q=80&w=1964&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            ],
            [
                'name' => 'Sony WH-1000XM5 Wireless Headphones',
                'description' => 'Industry-leading noise canceling with premium sound quality, 30-hour battery life, and speak-to-chat technology',
                'sku' => 'SONY-WH1000-001',
                'category_id' => $electronics->id,
                'subcategory_id' => $audioEquipment->id,
                'price' => 399.99,
                'cost_price' => 329.99,
                'current_stock' => 40,
                'minimum_stock' => 10,
                'maximum_stock' => 150,
                'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            ],
            [
                'name' => 'Samsung 65" QLED 4K Smart TV',
                'description' => 'Quantum 4K processor, 100% color volume, Object Tracking Sound, and premium design',
                'sku' => 'SAMS-QLED-001',
                'category_id' => $electronics->id,
                'subcategory_id' => null, // No subcategory for this product
                'price' => 1299.99,
                'cost_price' => 1099.99,
                'current_stock' => 12,
                'minimum_stock' => 3,
                'maximum_stock' => 40,
                'image_url' => 'https://images.unsplash.com/photo-1593305841991-13520844a5d5?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            ],
            [
                'name' => 'Canon EOS R5 Mirrorless Camera',
                'description' => '45MP full-frame sensor, 8K video recording, in-body image stabilization, and dual pixel CMOS AF II',
                'sku' => 'CAN-EOSR5-001',
                'category_id' => $electronics->id,
                'subcategory_id' => null, // No subcategory for this product
                'price' => 3899.99,
                'cost_price' => 3299.99,
                'current_stock' => 8,
                'minimum_stock' => 2,
                'maximum_stock' => 30,
                'image_url' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            ],
        ];

        // Office supplies with beautiful images
        $officeProducts = [
            [
                'name' => 'Premium Ergonomic Office Chair',
                'description' => 'Lumbar support, adjustable height, breathable mesh, 360-degree swivel, and premium comfort',
                'sku' => 'ERG-CHAIR-001',
                'category_id' => $furniture->id,
                'subcategory_id' => $chairs->id,
                'price' => 349.99,
                'cost_price' => 279.99,
                'current_stock' => 20,
                'minimum_stock' => 5,
                'maximum_stock' => 80,
                'image_url' => 'https://images.unsplash.com/photo-1592078615290-033ee584e267?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            ],
            [
                'name' => 'Standing Desk Converter',
                'description' => 'Adjustable height, spacious work surface, memory presets, and smooth pneumatic lift',
                'sku' => 'STAND-DESK-001',
                'category_id' => $furniture->id,
                'subcategory_id' => $desks->id,
                'price' => 249.99,
                'cost_price' => 199.99,
                'current_stock' => 18,
                'minimum_stock' => 4,
                'maximum_stock' => 60,
                'image_url' => 'https://images.unsplash.com/photo-1524758631624-e684a8d0266d?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            ],
            [
                'name' => 'LaserJet Pro M404n Printer',
                'description' => 'Fast monochrome printing, automatic two-sided printing, and high-yield toner compatibility',
                'sku' => 'HP-LASER-001',
                'category_id' => $officeSupplies->id,
                'subcategory_id' => $printing->id,
                'price' => 199.99,
                'cost_price' => 159.99,
                'current_stock' => 25,
                'minimum_stock' => 5,
                'maximum_stock' => 100,
                'image_url' => 'https://images.unsplash.com/photo-1588208565785-ff9c4ba70b98?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            ],
            [
                'name' => 'Premium Notebook Set',
                'description' => 'Set of 3 premium notebooks with different paper types, elastic closure, and pen loop',
                'sku' => 'NOTE-SET-001',
                'category_id' => $officeSupplies->id,
                'subcategory_id' => $stationery->id,
                'price' => 34.99,
                'cost_price' => 24.99,
                'current_stock' => 65,
                'minimum_stock' => 15,
                'maximum_stock' => 200,
                'image_url' => 'https://images.unsplash.com/photo-1498429152509-2a98e3a887e1?q=80&w=2040&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            ],
            [
                'name' => 'Wireless Mechanical Keyboard',
                'description' => 'RGB backlighting, programmable keys, long battery life, and premium tactile switches',
                'sku' => 'MECH-KEY-001',
                'category_id' => $electronics->id,
                'subcategory_id' => $computers->id,
                'price' => 89.99,
                'cost_price' => 64.99,
                'current_stock' => 45,
                'minimum_stock' => 10,
                'maximum_stock' => 150,
                'image_url' => 'https://images.unsplash.com/photo-1546833844-9d77a5c7c2e3?q=80&w=2067&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            ],
        ];

        // Tools & Equipment with beautiful images
        $toolsProducts = [
            [
                'name' => 'Milwaukee M18 Cordless Drill',
                'description' => '18V Lithium-Ion, 1/2-inch ratcheting chuck, fuel gauge, and REDLINK PLUS intelligence',
                'sku' => 'MIL-DRILL-001',
                'category_id' => $toolsEquipment->id,
                'subcategory_id' => $powerTools->id,
                'price' => 129.99,
                'cost_price' => 99.99,
                'current_stock' => 30,
                'minimum_stock' => 8,
                'maximum_stock' => 120,
                'image_url' => 'https://images.unsplash.com/photo-1582192034860-40f1b61a16b1?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            ],
            [
                'name' => 'Professional Socket Set',
                'description' => '65-piece socket set with metric and SAE sizes, organized in durable case',
                'sku' => 'SOCKET-SET-001',
                'category_id' => $toolsEquipment->id,
                'subcategory_id' => $handTools->id,
                'price' => 79.99,
                'cost_price' => 59.99,
                'current_stock' => 35,
                'minimum_stock' => 10,
                'maximum_stock' => 150,
                'image_url' => 'https://images.unsplash.com/photo-1605592438649-dc634d760c6e?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            ],
            [
                'name' => 'Safety Glasses with Side Shields',
                'description' => 'ANSI Z87.1+ rated, anti-fog coating, and comfortable wraparound design',
                'sku' => 'SAF-GLASS-001',
                'category_id' => $safetyEquipment->id,
                'subcategory_id' => $protectiveGear->id,
                'price' => 14.99,
                'cost_price' => 8.99,
                'current_stock' => 85,
                'minimum_stock' => 20,
                'maximum_stock' => 300,
                'image_url' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6f20?q=80&w=1996&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            ],
            [
                'name' => 'Adjustable Wrench Set',
                'description' => 'Set of 5 high-quality adjustable wrenches with comfortable grip and precise adjustment',
                'sku' => 'WRENCH-SET-001',
                'category_id' => $toolsEquipment->id,
                'subcategory_id' => $handTools->id,
                'price' => 29.99,
                'cost_price' => 19.99,
                'current_stock' => 50,
                'minimum_stock' => 15,
                'maximum_stock' => 200,
                'image_url' => 'https://images.unsplash.com/photo-1558494948-00813036a15d?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            ],
        ];

        // Combine all products and create them
        $allProducts = array_merge($electronicsProducts, $officeProducts, $toolsProducts);

        foreach ($allProducts as $productData) {
            // Check if product with SKU already exists to prevent duplicates
            if (!\App\Models\Product::where('sku', $productData['sku'])->exists()) {
                \App\Models\Product::create($productData);
            }
        }
    }
}
