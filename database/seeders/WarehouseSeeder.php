<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, let's populate the categories table if it's empty
        if (DB::table('categories')->count() === 0) {
            $categories = [
                [
                    'id' => (string) Str::uuid(),
                    'name' => 'Electronics',
                    'description' => 'Electronic devices and components',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'name' => 'Office Supplies',
                    'description' => 'Office equipment and stationery',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'name' => 'Tools & Equipment',
                    'description' => 'Industrial and workshop tools',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'name' => 'Furniture',
                    'description' => 'Office and warehouse furniture',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'name' => 'Safety Equipment',
                    'description' => 'Personal protective equipment',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'name' => 'Food & Beverages',
                    'description' => 'Food and beverage products',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'name' => 'Healthcare',
                    'description' => 'Healthcare and medical supplies',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'name' => 'Sports & Recreation',
                    'description' => 'Sports and recreational equipment',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ];

            DB::table('categories')->insert($categories);
        }

        // Populate subcategories table if it's empty
        if (DB::table('subcategories')->count() === 0) {
            $categoryIds = DB::table('categories')->pluck('id', 'name')->toArray();
            
            $subcategories = [
                [
                    'id' => (string) Str::uuid(),
                    'category_id' => $categoryIds['Electronics'],
                    'name' => 'Computers',
                    'description' => 'Desktop and laptop computers',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'category_id' => $categoryIds['Electronics'],
                    'name' => 'Mobile Devices',
                    'description' => 'Smartphones and tablets',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'category_id' => $categoryIds['Electronics'],
                    'name' => 'Audio Equipment',
                    'description' => 'Speakers and headphones',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'category_id' => $categoryIds['Electronics'],
                    'name' => 'TV & Video',
                    'description' => 'Televisions and video equipment',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'category_id' => $categoryIds['Office Supplies'],
                    'name' => 'Stationery',
                    'description' => 'Pens, papers, and writing materials',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'category_id' => $categoryIds['Office Supplies'],
                    'name' => 'Printing',
                    'description' => 'Printers and printing supplies',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'category_id' => $categoryIds['Tools & Equipment'],
                    'name' => 'Hand Tools',
                    'description' => 'Manual tools and equipment',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'category_id' => $categoryIds['Tools & Equipment'],
                    'name' => 'Power Tools',
                    'description' => 'Electric and battery tools',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'category_id' => $categoryIds['Furniture'],
                    'name' => 'Desks',
                    'description' => 'Office and work desks',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'category_id' => $categoryIds['Furniture'],
                    'name' => 'Chairs',
                    'description' => 'Office and ergonomic chairs',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'category_id' => $categoryIds['Safety Equipment'],
                    'name' => 'Protective Gear',
                    'description' => 'Helmets, gloves, and safety wear',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'category_id' => $categoryIds['Food & Beverages'],
                    'name' => 'Packaged Foods',
                    'description' => 'Canned and packaged food items',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'category_id' => $categoryIds['Healthcare'],
                    'name' => 'Medical Supplies',
                    'description' => 'Medical equipment and supplies',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'category_id' => $categoryIds['Sports & Recreation'],
                    'name' => 'Fitness Equipment',
                    'description' => 'Exercise and fitness equipment',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ];

            DB::table('subcategories')->insert($subcategories);
        }

        // Populate profiles table if it's empty
        if (DB::table('profiles')->count() === 0) {
            $profiles = [
                [
                    'id' => (string) Str::uuid(),
                    'user_id' => null,
                    'email' => 'admin@example.com',
                    'full_name' => 'John Admin',
                    'role' => 'admin',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'user_id' => null,
                    'email' => 'manager@example.com',
                    'full_name' => 'Jane Manager',
                    'role' => 'admin',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'user_id' => null,
                    'email' => 'user@example.com',
                    'full_name' => 'Bob User',
                    'role' => 'user',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ];

            DB::table('profiles')->insert($profiles);
        }

        // Populate products table if it's empty
        if (DB::table('products')->count() === 0) {
            $categoryIds = DB::table('categories')->pluck('id', 'name')->toArray();
            $subcategoryIds = DB::table('subcategories')->pluck('id', 'name')->toArray();
            
            $products = [
                [
                    'id' => (string) Str::uuid(),
                    'name' => 'Dell OptiPlex 7090',
                    'description' => 'High-performance desktop computer for office use',
                    'sku' => 'DELL-7090-001',
                    'category_id' => $categoryIds['Electronics'],
                    'subcategory_id' => $subcategoryIds['Computers'],
                    'price' => 899.99,
                    'cost_price' => 650.00,
                    'current_stock' => 25,
                    'minimum_stock' => 5,
                    'maximum_stock' => 50,
                    'image_url' => 'https://images.pexels.com/photos/2148217/pexels-photo-2148217.jpeg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'name' => 'iPhone 14 Pro',
                    'description' => 'Latest Apple smartphone with advanced camera system',
                    'sku' => 'APPLE-IP14P-001',
                    'category_id' => $categoryIds['Electronics'],
                    'subcategory_id' => $subcategoryIds['Mobile Devices'],
                    'price' => 1099.99,
                    'cost_price' => 800.00,
                    'current_stock' => 15,
                    'minimum_stock' => 3,
                    'maximum_stock' => 30,
                    'image_url' => 'https://images.pexels.com/photos/788946/pexels-photo-788946.jpeg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'name' => 'Sony WH-1000XM4',
                    'description' => 'Wireless noise-canceling headphones',
                    'sku' => 'SONY-WH1000-001',
                    'category_id' => $categoryIds['Electronics'],
                    'subcategory_id' => $subcategoryIds['Audio Equipment'],
                    'price' => 349.99,
                    'cost_price' => 250.00,
                    'current_stock' => 40,
                    'minimum_stock' => 10,
                    'maximum_stock' => 80,
                    'image_url' => 'https://images.pexels.com/photos/3394650/pexels-photo-3394650.jpeg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'name' => 'HP LaserJet Pro',
                    'description' => 'Professional laser printer for office use',
                    'sku' => 'HP-LJ-PRO-001',
                    'category_id' => $categoryIds['Office Supplies'],
                    'subcategory_id' => $subcategoryIds['Printing'],
                    'price' => 299.99,
                    'cost_price' => 200.00,
                    'current_stock' => 12,
                    'minimum_stock' => 2,
                    'maximum_stock' => 25,
                    'image_url' => 'https://images.pexels.com/photos/4226140/pexels-photo-4226140.jpeg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'name' => 'Ergonomic Office Chair',
                    'description' => 'Comfortable ergonomic chair with lumbar support',
                    'sku' => 'CHAIR-ERG-001',
                    'category_id' => $categoryIds['Furniture'],
                    'subcategory_id' => $subcategoryIds['Chairs'],
                    'price' => 249.99,
                    'cost_price' => 150.00,
                    'current_stock' => 30,
                    'minimum_stock' => 5,
                    'maximum_stock' => 60,
                    'image_url' => 'https://images.pexels.com/photos/586344/pexels-photo-586344.jpeg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'name' => 'DeWalt Cordless Drill',
                    'description' => 'Professional cordless drill with battery pack',
                    'sku' => 'DEWALT-CD-001',
                    'category_id' => $categoryIds['Tools & Equipment'],
                    'subcategory_id' => $subcategoryIds['Power Tools'],
                    'price' => 179.99,
                    'cost_price' => 120.00,
                    'current_stock' => 22,
                    'minimum_stock' => 5,
                    'maximum_stock' => 40,
                    'image_url' => 'https://images.pexels.com/photos/1249611/pexels-photo-1249611.jpeg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'name' => 'Safety Helmet',
                    'description' => 'Industrial safety helmet with adjustable strap',
                    'sku' => 'HELMET-SF-001',
                    'category_id' => $categoryIds['Safety Equipment'],
                    'subcategory_id' => $subcategoryIds['Protective Gear'],
                    'price' => 29.99,
                    'cost_price' => 18.00,
                    'current_stock' => 50,
                    'minimum_stock' => 10,
                    'maximum_stock' => 100,
                    'image_url' => 'https://images.pexels.com/photos/1117452/pexels-photo-1117452.jpeg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'name' => 'Standing Desk',
                    'description' => 'Height-adjustable standing desk',
                    'sku' => 'DESK-STAND-001',
                    'category_id' => $categoryIds['Furniture'],
                    'subcategory_id' => $subcategoryIds['Desks'],
                    'price' => 599.99,
                    'cost_price' => 400.00,
                    'current_stock' => 8,
                    'minimum_stock' => 2,
                    'maximum_stock' => 20,
                    'image_url' => 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'name' => 'Wireless Mouse',
                    'description' => 'Ergonomic wireless optical mouse',
                    'sku' => 'MOUSE-WL-001',
                    'category_id' => $categoryIds['Electronics'],
                    'subcategory_id' => $subcategoryIds['Computers'],
                    'price' => 39.99,
                    'cost_price' => 25.00,
                    'current_stock' => 75,
                    'minimum_stock' => 15,
                    'maximum_stock' => 150,
                    'image_url' => 'https://images.pexels.com/photos/2115256/pexels-photo-2115256.jpeg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'name' => 'Notebook Set',
                    'description' => 'Professional notebook set with pens',
                    'sku' => 'NOTEBOOK-SET-001',
                    'category_id' => $categoryIds['Office Supplies'],
                    'subcategory_id' => $subcategoryIds['Stationery'],
                    'price' => 19.99,
                    'cost_price' => 12.00,
                    'current_stock' => 100,
                    'minimum_stock' => 20,
                    'maximum_stock' => 200,
                    'image_url' => 'https://images.pexels.com/photos/1925536/pexels-photo-1925536.jpeg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'name' => 'Bluetooth Speaker',
                    'description' => 'Portable wireless Bluetooth speaker',
                    'sku' => 'SPEAKER-BT-001',
                    'category_id' => $categoryIds['Electronics'],
                    'subcategory_id' => $subcategoryIds['Audio Equipment'],
                    'price' => 89.99,
                    'cost_price' => 60.00,
                    'current_stock' => 35,
                    'minimum_stock' => 8,
                    'maximum_stock' => 70,
                    'image_url' => 'https://images.pexels.com/photos/1649771/pexels-photo-1649771.jpeg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'name' => 'Tool Set',
                    'description' => 'Complete hand tool set with carrying case',
                    'sku' => 'TOOLSET-HAND-001',
                    'category_id' => $categoryIds['Tools & Equipment'],
                    'subcategory_id' => $subcategoryIds['Hand Tools'],
                    'price' => 129.99,
                    'cost_price' => 85.00,
                    'current_stock' => 18,
                    'minimum_stock' => 3,
                    'maximum_stock' => 35,
                    'image_url' => 'https://images.pexels.com/photos/1249611/pexels-photo-1249611.jpeg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'name' => '4K Smart TV',
                    'description' => '55-inch 4K Ultra HD Smart TV with HDR',
                    'sku' => 'TV-SMART-001',
                    'category_id' => $categoryIds['Electronics'],
                    'subcategory_id' => $subcategoryIds['TV & Video'],
                    'price' => 699.99,
                    'cost_price' => 500.00,
                    'current_stock' => 10,
                    'minimum_stock' => 2,
                    'maximum_stock' => 20,
                    'image_url' => 'https://images.pexels.com/photos/1325983/pexels-photo-1325983.jpeg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'name' => 'Protein Powder',
                    'description' => 'Whey protein powder, vanilla flavor, 2kg',
                    'sku' => 'PROTEIN-VAN-001',
                    'category_id' => $categoryIds['Sports & Recreation'],
                    'subcategory_id' => $subcategoryIds['Fitness Equipment'],
                    'price' => 49.99,
                    'cost_price' => 30.00,
                    'current_stock' => 60,
                    'minimum_stock' => 10,
                    'maximum_stock' => 120,
                    'image_url' => 'https://images.pexels.com/photos/410908/pexels-photo-410908.jpeg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => (string) Str::uuid(),
                    'name' => 'Dumbbell Set',
                    'description' => 'Adjustable dumbbell set, 5-25 lbs',
                    'sku' => 'DUMBBELL-SET-001',
                    'category_id' => $categoryIds['Sports & Recreation'],
                    'subcategory_id' => $subcategoryIds['Fitness Equipment'],
                    'price' => 199.99,
                    'cost_price' => 140.00,
                    'current_stock' => 15,
                    'minimum_stock' => 3,
                    'maximum_stock' => 30,
                    'image_url' => 'https://images.pexels.com/photos/1925789/pexels-photo-1925789.jpeg',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ];

            DB::table('products')->insert($products);
        }

        // Only populate related records if the required tables have data
        $profileIds = DB::table('profiles')->pluck('id')->toArray();
        $productIds = DB::table('products')->pluck('id')->toArray();
        
        // Populate stock movements only if profiles and products exist
        if (!empty($profileIds) && !empty($productIds) && DB::table('stock_movements')->count() === 0) {
            $stockMovements = [];
            $movementTypes = ['incoming', 'outgoing', 'purchase', 'sale', 'borrow', 'return'];
            
            for ($i = 0; $i < 50; $i++) {
                $stockMovements[] = [
                    'id' => (string) Str::uuid(),
                    'product_id' => $productIds[array_rand($productIds)],
                    'movement_type' => $movementTypes[array_rand($movementTypes)],
                    'quantity' => rand(1, 20),
                    'unit_price' => rand(100, 1000) / 10,
                    'total_amount' => rand(100, 5000) / 10,
                    'notes' => 'Sample stock movement',
                    'created_by' => $profileIds[array_rand($profileIds)],
                    'created_at' => now()->subDays(rand(0, 30))
                ];
            }
            
            DB::table('stock_movements')->insert($stockMovements);
        }

        // Populate purchases only if profiles exist
        if (!empty($profileIds) && DB::table('purchases')->count() === 0) {
            $purchases = [];
            $suppliers = [
                'Electro Supplies Inc.',
                'Office Depot Pro',
                'Tool Masters Co.',
                'Furniture World Ltd',
                'Safety First Corp',
                'Health & Medical Supplies',
                'Sports Direct',
                'Tech Solutions Co.'
            ];
            
            for ($i = 0; $i < 20; $i++) {
                $purchases[] = [
                    'id' => (string) Str::uuid(),
                    'supplier_name' => $suppliers[array_rand($suppliers)],
                    'supplier_contact' => 'contact@' . strtolower(str_replace(' ', '', $suppliers[array_rand($suppliers)])) . '.com',
                    'purchase_date' => now()->subDays(rand(0, 60)),
                    'total_amount' => rand(500, 5000) / 10,
                    'notes' => 'Purchase order #' . rand(1000, 9999),
                    'created_by' => $profileIds[array_rand($profileIds)],
                    'created_at' => now()->subDays(rand(0, 60)),
                    'updated_at' => now()->subDays(rand(0, 60))
                ];
            }
            
            DB::table('purchases')->insert($purchases);
        }

        // Populate sales only if profiles exist
        if (!empty($profileIds) && DB::table('sales')->count() === 0) {
            $sales = [];
            $customers = [
                'ABC Corporation',
                'XYZ Enterprises',
                'Global Solutions Ltd',
                'Tech Innovations Inc',
                'Modern Office Co',
                'Health First Hospital',
                'Sports Zone',
                'Construction Pros'
            ];
            
            for ($i = 0; $i < 30; $i++) {
                $sales[] = [
                    'id' => (string) Str::uuid(),
                    'customer_name' => $customers[array_rand($customers)],
                    'customer_contact' => 'contact@' . strtolower(str_replace(' ', '', $customers[array_rand($customers)])) . '.com',
                    'sale_date' => now()->subDays(rand(0, 45)),
                    'total_amount' => rand(100, 3000) / 10,
                    'notes' => 'Sales order #' . rand(1000, 9999),
                    'created_by' => $profileIds[array_rand($profileIds)],
                    'created_at' => now()->subDays(rand(0, 45)),
                    'updated_at' => now()->subDays(rand(0, 45))
                ];
            }
            
            DB::table('sales')->insert($sales);
        }

        // Populate warranties only if products exist
        if (!empty($productIds) && DB::table('warranties')->count() === 0) {
            $warranties = [];
            
            for ($i = 0; $i < 15; $i++) {
                $startDate = now()->subDays(rand(0, 180));
                $warranties[] = [
                    'id' => (string) Str::uuid(),
                    'product_id' => $productIds[array_rand($productIds)],
                    'warranty_start_date' => $startDate,
                    'warranty_end_date' => $startDate->copy()->addYears(2),
                    'warranty_terms' => 'Standard 2-year manufacturer warranty',
                    'customer_name' => 'Customer ' . ($i + 1),
                    'customer_contact' => 'customer' . ($i + 1) . '@example.com',
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            
            DB::table('warranties')->insert($warranties);
        }

        // Populate borrowings only if products and profiles exist
        if (!empty($productIds) && !empty($profileIds) && DB::table('borrowings')->count() === 0) {
            $borrowings = [];
            $borrowers = [
                'Employee A',
                'Employee B',
                'Contractor X',
                'Department Y',
                'Visitor 1',
                'Visitor 2',
                'Temporary Staff',
                'Client Z'
            ];
            
            for ($i = 0; $i < 25; $i++) {
                $borrowDate = now()->subDays(rand(1, 30));
                $expectedReturn = $borrowDate->copy()->addDays(rand(7, 30));
                
                $status = 'active';
                if ($expectedReturn->isPast()) {
                    $status = rand(0, 1) ? 'overdue' : 'active';
                }
                
                $borrowings[] = [
                    'id' => (string) Str::uuid(),
                    'product_id' => $productIds[array_rand($productIds)],
                    'borrower_name' => $borrowers[array_rand($borrowers)],
                    'borrower_contact' => 'borrower' . ($i + 1) . '@company.com',
                    'quantity' => rand(1, 3),
                    'borrow_date' => $borrowDate,
                    'expected_return_date' => $expectedReturn,
                    'actual_return_date' => $status === 'returned' ? $borrowDate->copy()->addDays(rand(1, 14)) : null,
                    'status' => $status,
                    'notes' => 'Equipment borrowing for project',
                    'created_by' => $profileIds[array_rand($profileIds)],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            
            DB::table('borrowings')->insert($borrowings);
        }
        
        echo "WarehouseSeeder completed. All warehouse tables have been populated with sample data.\n";
    }
}