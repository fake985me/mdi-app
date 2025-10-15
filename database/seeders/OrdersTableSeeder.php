<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get user IDs from the users table
        $userIds = DB::table('users')->pluck('id')->toArray();
        
        // Get product IDs from the products table
        $productIds = DB::table('products')->pluck('id')->toArray();
        
        // Only create orders if we have users and products
        if (!empty($userIds) && !empty($productIds)) {
            // Create sample orders
            $orders = [];
            $orderItems = [];
            
            // Generate 20 sample orders
            for ($i = 0; $i < 20; $i++) {
                $userId = $userIds[array_rand($userIds)];
                $orderId = (string) Str::uuid();
                $orderNumber = 'ORD-' . strtoupper(Str::random(8));
                $status = ['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'][array_rand(['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'])];
                $paymentStatus = ['pending', 'paid', 'failed', 'refunded'][array_rand(['pending', 'paid', 'failed', 'refunded'])];
                
                // Generate random shipping and billing addresses
                $addresses = [
                    [
                        'street' => 'Jl. Sudirman No. ' . rand(1, 100),
                        'city' => ['Jakarta', 'Bandung', 'Surabaya', 'Medan', 'Semarang'][array_rand(['Jakarta', 'Bandung', 'Surabaya', 'Medan', 'Semarang'])],
                        'province' => 'DKI Jakarta',
                        'postal_code' => '12345',
                        'country' => 'Indonesia'
                    ],
                    [
                        'street' => 'Jl. Thamrin No. ' . rand(1, 100),
                        'city' => ['Jakarta', 'Bandung', 'Surabaya', 'Medan', 'Semarang'][array_rand(['Jakarta', 'Bandung', 'Surabaya', 'Medan', 'Semarang'])],
                        'province' => 'Jawa Barat',
                        'postal_code' => '54321',
                        'country' => 'Indonesia'
                    ]
                ];
                
                $order = [
                    'id' => $orderId,
                    'user_id' => $userId,
                    'order_number' => $orderNumber,
                    'status' => $status,
                    'total_amount' => rand(10000, 1000000) / 100, // Random amount between 100 and 10,000
                    'shipping_address' => json_encode($addresses[0]),
                    'billing_address' => json_encode($addresses[1]),
                    'payment_method' => ['credit_card', 'bank_transfer', 'cash_on_delivery'][array_rand(['credit_card', 'bank_transfer', 'cash_on_delivery'])],
                    'payment_status' => $paymentStatus,
                    'created_at' => now()->subDays(rand(1, 60)),
                    'updated_at' => now()->subDays(rand(0, 30)),
                ];
                
                $orders[] = $order;
                
                // Create 1-5 order items for each order
                $numItems = rand(1, 5);
                $totalAmount = 0;
                
                for ($j = 0; $j < $numItems; $j++) {
                    $productId = $productIds[array_rand($productIds)];
                    $quantity = rand(1, 10);
                    $price = rand(5000, 500000) / 100; // Random price between 50 and 5,000
                    $itemTotal = $quantity * $price;
                    $totalAmount += $itemTotal;
                    
                    $orderItems[] = [
                        'id' => (string) Str::uuid(),
                        'order_id' => $orderId,
                        'product_id' => $productId,
                        'quantity' => $quantity,
                        'price' => $price,
                        'created_at' => $order['created_at'],
                        'updated_at' => $order['updated_at'],
                    ];
                }
                
                // Update the order total amount
                $order['total_amount'] = $totalAmount;
                $orders[count($orders) - 1] = $order;
            }
            
            // Insert orders
            DB::table('orders')->insert($orders);
            
            // Insert order items
            DB::table('order_items')->insert($orderItems);
        }
    }
}