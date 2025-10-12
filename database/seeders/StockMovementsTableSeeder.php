<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockMovementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a profile and products for stock movements
        $profile = \App\Models\Profile::first();
        $products = \App\Models\Product::limit(4)->get();
        
        foreach($products as $product) {
            // Check if similar stock movements already exist for this product
            $existingIncoming = \App\Models\StockMovement::where('product_id', $product->id)
                ->where('movement_type', 'incoming')
                ->where('quantity', 10)
                ->first();
                
            if (!$existingIncoming) {
                // Incoming stock movement
                \App\Models\StockMovement::create([
                    'product_id' => $product->id,
                    'movement_type' => 'incoming',
                    'quantity' => 10,
                    'unit_price' => $product->cost_price,
                    'total_amount' => $product->cost_price * 10,
                    'notes' => 'Initial stock addition for ' . $product->name,
                    'created_by' => $profile->id,
                ]);
            }
            
            $existingOutgoing = \App\Models\StockMovement::where('product_id', $product->id)
                ->where('movement_type', 'outgoing')
                ->where('quantity', 2)
                ->first();
                
            if (!$existingOutgoing) {
                // Outgoing stock movement (sale)
                \App\Models\StockMovement::create([
                    'product_id' => $product->id,
                    'movement_type' => 'outgoing',
                    'quantity' => 2,
                    'unit_price' => $product->price,
                    'total_amount' => $product->price * 2,
                    'notes' => 'Stock reduction for sale of ' . $product->name,
                    'created_by' => $profile->id,
                ]);
            }
        }
    }
}
