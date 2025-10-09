<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale;
use App\Models\Customer;
use Carbon\Carbon;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::all();
        
        if ($customers->count() > 0) {
            for ($i = 1; $i <= 5; $i++) {
                $customer = $customers->random();
                
                Sale::create([
                    'sale_number' => 'SAL-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                    'customer_id' => $customer->id,
                    'date' => Carbon::now()->subDays(rand(1, 30)),
                    'total' => rand(500, 5000) / 10, // Convert to decimal
                    'notes' => "Sale invoice #{$i} to {$customer->name}",
                    'status' => ['pending', 'completed', 'completed'][array_rand(['pending', 'completed', 'completed'])] // 2/3 chance of completed
                ]);
            }
        }
    }
}