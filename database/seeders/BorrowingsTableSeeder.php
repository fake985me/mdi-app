<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BorrowingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a profile and products for borrowing
        $profile = \App\Models\Profile::first();
        $products = \App\Models\Product::limit(2)->get();
        
        foreach($products as $product) {
            // Check if a borrowing already exists for this product
            $existingBorrowing = \App\Models\Borrowing::where('product_id', $product->id)
                ->where('borrower_name', 'Borrower ' . $product->name)
                ->first();
                
            if (!$existingBorrowing) {
                \App\Models\Borrowing::create([
                    'product_id' => $product->id,
                    'borrower_name' => 'Borrower ' . $product->name,
                    'borrower_contact' => 'borrower@example.com',
                    'quantity' => 1,
                    'borrow_date' => now(),
                    'expected_return_date' => now()->addWeeks(2),
                    'status' => 'active',
                    'notes' => 'Borrowed ' . $product->name . ' for testing purposes',
                    'created_by' => $profile->id,
                ]);
            }
        }
    }
}
