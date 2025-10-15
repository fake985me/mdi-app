<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;

class SalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users, customers, and products for the sales
        $users = User::all();
        $customers = Customer::all();
        $products = Product::all();
        
        if ($users->count() === 0 || $customers->count() === 0 || $products->count() === 0) {
            return; // Don't create sales if required data doesn't exist
        }

        // Create 15 sample sales
        for ($i = 0; $i < 15; $i++) {
            $user = $users->random();
            $customer = $customers->random();
            
            // Create a sale with random data
            $sale = Sale::create([
                'user_id' => $user->id,
                'customer_id' => $customer->id,
                'sale_date' => now()->subDays(rand(0, 30)),
                'total_amount' => 0, // Will be calculated based on items
                'notes' => 'Sale #'.($i+1).' for ' . $customer->name,
            ]);

            // Add 1-4 items to this sale
            $totalAmount = 0;
            $numItems = rand(1, 4);
            
            for ($j = 0; $j < $numItems; $j++) {
                $product = $products->random();
                
                // Determine quantity and price (might be different from product price)
                $quantity = rand(1, 5);
                $unitPrice = $product->price ?: rand(50, 500);
                $itemTotal = $quantity * $unitPrice;
                
                // Create sale item
                $saleItem = SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_amount' => $itemTotal,
                ]);
                
                $totalAmount += $itemTotal;
            }
            
            // Update the sale total
            $sale->update(['total_amount' => $totalAmount]);
        }
    }
}
