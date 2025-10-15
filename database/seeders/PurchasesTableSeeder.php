<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\User;

class PurchasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users, suppliers, and products for the purchase
        $users = User::all();
        $suppliers = Supplier::all();
        $products = Product::all();
        
        if ($users->count() === 0 || $suppliers->count() === 0 || $products->count() === 0) {
            return; // Don't create purchases if required data doesn't exist
        }

        // Create 10 sample purchases
        for ($i = 0; $i < 10; $i++) {
            $user = $users->random();
            $supplier = $suppliers->random();
            
            // Create a purchase with random data
            $purchase = Purchase::create([
                'user_id' => $user->id,
                'supplier_id' => $supplier->id,
                'purchase_date' => now()->subDays(rand(0, 30)),
                'total_amount' => 0, // Will be calculated based on items
                'notes' => 'Purchase #'.($i+1).' for ' . $supplier->name,
            ]);

            // Add 1-3 items to this purchase
            $totalAmount = 0;
            $numItems = rand(1, 3);
            
            for ($j = 0; $j < $numItems; $j++) {
                $product = $products->random();
                
                // Determine quantity and price
                $quantity = rand(5, 20);
                $unitPrice = $product->cost_price ?: rand(50, 500);
                $itemTotal = $quantity * $unitPrice;
                
                // Create purchase item
                $purchaseItem = PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_amount' => $itemTotal,
                ]);
                
                $totalAmount += $itemTotal;
            }
            
            // Update the purchase total
            $purchase->update(['total_amount' => $totalAmount]);
        }
    }
}
