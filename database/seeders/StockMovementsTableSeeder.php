<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StockMovement;
use App\Models\Product;
use App\Models\User;

class StockMovementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users and products for stock movements
        $users = User::all();
        $products = Product::all();
        
        if ($users->count() === 0 || $products->count() === 0) {
            return; // Don't create stock movements if required data doesn't exist
        }

        // Create 20 sample stock movements
        for ($i = 0; $i < 20; $i++) {
            $user = $users->random();
            $product = $products->random();
            
            // Randomly determine movement type and details
            $movementTypes = ['incoming', 'outgoing', 'purchase', 'sale', 'borrow', 'return'];
            $movementType = $movementTypes[array_rand($movementTypes)];
            
            // Determine quantity based on movement type
            $quantity = match($movementType) {
                'incoming', 'purchase' => rand(5, 30),
                'outgoing', 'sale' => rand(1, 5),
                'borrow' => rand(1, 3),
                'return' => rand(1, 3),
                default => rand(1, 10)
            };
            
            // Determine price based on movement type
            $unitPrice = match($movementType) {
                'incoming', 'purchase' => $product->cost_price ?: rand(50, 500),
                'outgoing', 'sale' => $product->price ?: rand(60, 600),
                default => ($product->cost_price + $product->price) / 2
            };
            
            $totalAmount = $quantity * $unitPrice;
            
            // Create stock movement
            StockMovement::create([
                'product_id' => $product->id,
                'user_id' => $user->id,
                'movement_type' => $movementType,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'total_amount' => $totalAmount,
                'notes' => 'Stock ' . $movementType . ' for ' . $product->name . ' by ' . $user->name,
            ]);
        }
    }
}
