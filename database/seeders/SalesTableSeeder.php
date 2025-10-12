<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a profile and products for the sale
        $profile = \App\Models\Profile::first();
        $products = \App\Models\Product::limit(3)->get();
        
        foreach($products as $product) {
            // Check if a similar sale record already exists
            $existingSale = \App\Models\Sale::where('customer_name', 'Customer ' . $product->name)
                ->where('created_by', $profile->id)
                ->first();
                
            if (!$existingSale) {
                \App\Models\Sale::create([
                    'customer_name' => 'Customer ' . $product->name,
                    'customer_contact' => 'customer@example.com',
                    'sale_date' => now(),
                    'total_amount' => $product->price * 2, // Sell 2 units
                    'notes' => 'Sale of ' . $product->name,
                    'created_by' => $profile->id,
                ]);
            }
        }
    }
}
