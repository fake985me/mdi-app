<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WarrantyItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get warranty IDs from the warranties table
        $warrantyIds = DB::table('warranties')->pluck('id')->toArray();
        
        // Get product IDs from the products table
        $productIds = DB::table('products')->pluck('id')->toArray();
        
        // Only create warranty items if we have warranties and products
        if (!empty($warrantyIds) && !empty($productIds)) {
            $warrantyItems = [];
            
            // Generate warranty items for each warranty
            foreach ($warrantyIds as $warrantyId) {
                // Get the warranty
                $warranty = DB::table('warranties')->where('id', $warrantyId)->first();
                
                // Create 1-3 warranty items for each warranty
                $numItems = rand(1, 3);
                
                for ($i = 0; $i < $numItems; $i++) {
                    $productId = $productIds[array_rand($productIds)];
                    $quantity = rand(1, 5);
                    $unitPrice = rand(10000, 1000000) / 100; // Random price between 100 and 10,000
                    $totalAmount = $quantity * $unitPrice;
                    
                    $warrantyItems[] = [
                        'id' => (string) Str::uuid(),
                        'warranty_id' => $warrantyId,
                        'product_id' => $productId,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'total_amount' => $totalAmount,
                        'created_at' => $warranty->created_at ?? now(),
                        'updated_at' => $warranty->updated_at ?? now(),
                    ];
                }
            }
            
            // Insert warranty items
            DB::table('warranty_items')->insert($warrantyItems);
        }
    }
}