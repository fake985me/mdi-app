<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Borrowing;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;

class BorrowingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users, customers, and products for borrowings
        $users = User::all();
        $customers = Customer::all();
        $products = Product::all();
        
        if ($users->count() === 0 || $customers->count() === 0 || $products->count() === 0) {
            return; // Don't create borrowings if required data doesn't exist
        }

        // Create 10 sample borrowings
        for ($i = 0; $i < 10; $i++) {
            $user = $users->random();
            $customer = $customers->random();
            $product = $products->random();
            
            // Determine if the borrowing is still active or returned
            $status = rand(0, 1) ? 'active' : 'returned'; // 50% chance of being returned
            
            // Create borrowing
            $borrowing = Borrowing::create([
                'product_id' => $product->id,
                'customer_id' => $customer->id,
                'user_id' => $user->id,
                'quantity' => rand(1, 3),
                'borrow_date' => now()->subDays(rand(1, 60)), // Borrowed 1-60 days ago
                'expected_return_date' => now()->addDays(rand(1, 30)), // Expected return in 1-30 days
                'actual_return_date' => $status === 'returned' ? now()->subDays(rand(0, 5)) : null,
                'status' => $status,
                'notes' => 'Borrowed ' . $product->name . ' by ' . $customer->name,
            ]);
        }
    }
}
