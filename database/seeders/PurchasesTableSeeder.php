<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurchasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a profile and products for the purchase
        $profile = \App\Models\Profile::first();
        $products = \App\Models\Product::limit(5)->get();
        
        foreach($products as $product) {
            // Check if a similar purchase record already exists
            $existingPurchase = \App\Models\Purchase::where('supplier_name', 'Supplier ' . $product->name)
                ->where('created_by', $profile->id)
                ->first();
                
            if (!$existingPurchase) {
                \App\Models\Purchase::create([
                    'supplier_name' => 'Supplier ' . $product->name,
                    'supplier_contact' => 'contact@supplier.com',
                    'purchase_date' => now(),
                    'total_amount' => $product->price * 10, // Purchase 10 units
                    'notes' => 'Initial inventory purchase for ' . $product->name,
                    'created_by' => $profile->id,
                ]);
            }
        }
    }
}
