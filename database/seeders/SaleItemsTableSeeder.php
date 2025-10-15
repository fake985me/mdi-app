<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SaleItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get sale IDs from the sales table
        $saleIds = DB::table('sales')->pluck('id')->toArray();
        
        // Get product IDs from the products table
        $productIds = DB::table('products')->pluck('id')->toArray();
        
        // Only create sale items if we have sales and products
        if (!empty($saleIds) && !empty($productIds)) {
            $saleItems = [];
            
            // Generate sale items for each sale
            foreach ($saleIds as $saleId) {
                // Get the sale to determine created_by
                $sale = DB::table('sales')->where('id', $saleId)->first();
                
                // Create 1-5 sale items for each sale
                $numItems = rand(1, 5);
                
                for ($i = 0; $i < $numItems; $i++) {
                    $productId = $productIds[array_rand($productIds)];
                    $quantity = rand(1, 20);
                    $unitPrice = rand(5000, 500000) / 100; // Random price between 50 and 5,000
                    $totalAmount = $quantity * $unitPrice;
                    
                    $saleItems[] = [
                        'id' => (string) Str::uuid(),
                        'sale_id' => $saleId,
                        'product_id' => $productId,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'total_amount' => $totalAmount,
                        'created_at' => $sale->created_at ?? now(),
                        'updated_at' => $sale->updated_at ?? now(),
                    ];
                }
            }
            
            // Insert sale items
            DB::table('sale_items')->insert($saleItems);
        }
    }
}