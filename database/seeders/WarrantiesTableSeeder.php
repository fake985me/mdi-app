<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarrantiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get products for warranties
        $products = \App\Models\Product::limit(3)->get();
        
        foreach($products as $product) {
            // Check if a warranty already exists for this product
            $existingWarranty = \App\Models\Warranty::where('product_id', $product->id)
                ->where('customer_name', 'Customer ' . $product->name)
                ->first();
                
            if (!$existingWarranty) {
                \App\Models\Warranty::create([
                    'product_id' => $product->id,
                    'warranty_start_date' => now(),
                    'warranty_end_date' => now()->addYear(), // 1 year warranty
                    'warranty_terms' => 'Standard manufacturer warranty for ' . $product->name,
                    'customer_name' => 'Customer ' . $product->name,
                    'customer_contact' => 'customer@example.com',
                ]);
            }
        }
    }
}
