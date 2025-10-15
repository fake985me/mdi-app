<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PurchaseItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get purchase IDs from the purchases table
        $purchaseIds = DB::table('purchases')->pluck('id')->toArray();
        
        // Get product IDs from the products table
        $productIds = DB::table('products')->pluck('id')->toArray();
        
        // Only create purchase items if we have purchases and products
        if (!empty($purchaseIds) && !empty($productIds)) {
            $purchaseItems = [];
            
            // Generate purchase items for each purchase
            foreach ($purchaseIds as $purchaseId) {
                // Get the purchase to determine created_by
                $purchase = DB::table('purchases')->where('id', $purchaseId)->first();
                
                // Create 1-5 purchase items for each purchase
                $numItems = rand(1, 5);
                
                for ($i = 0; $i < $numItems; $i++) {
                    $productId = $productIds[array_rand($productIds)];
                    $quantity = rand(5, 50);
                    $unitPrice = rand(10000, 1000000) / 100; // Random price between 100 and 10,000
                    $totalAmount = $quantity * $unitPrice;
                    
                    $purchaseItems[] = [
                        'id' => (string) Str::uuid(),
                        'purchase_id' => $purchaseId,
                        'product_id' => $productId,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'total_amount' => $totalAmount,
                        'created_at' => $purchase->created_at ?? now(),
                        'updated_at' => $purchase->updated_at ?? now(),
                    ];
                }
            }
            
            // Insert purchase items
            DB::table('purchase_items')->insert($purchaseItems);
        }
    }
}