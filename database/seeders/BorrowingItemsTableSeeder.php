<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BorrowingItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get borrowing IDs from the borrowings table
        $borrowingIds = DB::table('borrowings')->pluck('id')->toArray();
        
        // Get product IDs from the products table
        $productIds = DB::table('products')->pluck('id')->toArray();
        
        // Only create borrowing items if we have borrowings and products
        if (!empty($borrowingIds) && !empty($productIds)) {
            $borrowingItems = [];
            
            // Generate borrowing items for each borrowing
            foreach ($borrowingIds as $borrowingId) {
                // Get the borrowing
                $borrowing = DB::table('borrowings')->where('id', $borrowingId)->first();
                
                // Create 1-3 borrowing items for each borrowing
                $numItems = rand(1, 3);
                
                for ($i = 0; $i < $numItems; $i++) {
                    $productId = $productIds[array_rand($productIds)];
                    $quantity = rand(1, 10);
                    $unitPrice = rand(5000, 500000) / 100; // Random price between 50 and 5,000
                    $totalAmount = $quantity * $unitPrice;
                    
                    $borrowingItems[] = [
                        'id' => (string) Str::uuid(),
                        'borrowing_id' => $borrowingId,
                        'product_id' => $productId,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'total_amount' => $totalAmount,
                        'created_at' => $borrowing->created_at ?? now(),
                        'updated_at' => $borrowing->updated_at ?? now(),
                    ];
                }
            }
            
            // Insert borrowing items
            DB::table('borrowing_items')->insert($borrowingItems);
        }
    }
}