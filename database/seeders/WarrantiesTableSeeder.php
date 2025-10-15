<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Warranty;
use App\Models\Customer;
use App\Models\Product;

class WarrantiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get customers and products for warranties
        $customers = Customer::all();
        $products = Product::all();
        
        if ($customers->count() === 0 || $products->count() === 0) {
            return; // Don't create warranties if required data doesn't exist
        }

        // Create 8 sample warranties
        for ($i = 0; $i < 8; $i++) {
            $customer = $customers->random();
            $product = $products->random();
            
            // Skip if warranty already exists for this product-customer combination
            $existingWarranty = Warranty::where('product_id', $product->id)
                ->where('customer_id', $customer->id)
                ->first();
                
            if (!$existingWarranty) {
                Warranty::create([
                    'product_id' => $product->id,
                    'customer_id' => $customer->id,
                    'warranty_start_date' => now()->subDays(rand(0, 365)), // Random start date in the past year
                    'warranty_end_date' => now()->addDays(rand(365, 730)), // 1-2 years warranty
                    'warranty_terms' => 'Standard manufacturer warranty for ' . $product->name . ' purchased by ' . $customer->name,
                ]);
            }
        }
    }
}
