<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Loan;
use App\Models\Item;
use Carbon\Carbon;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = Item::all();
        
        if ($items->count() > 0) {
            for ($i = 1; $i <= 5; $i++) {
                $item = $items->random();
                
                Loan::create([
                    'item_id' => $item->id,
                    'borrower' => "Employee {$i}",
                    'loan_date' => Carbon::now()->subDays(rand(1, 30)),
                    'return_date' => rand(0, 1) ? Carbon::now()->addDays(rand(1, 14)) : null, // 50% chance of future return date
                    'status' => ['dipinjam', 'dikembalikan', 'terlambat'][array_rand(['dipinjam', 'dikembalikan', 'terlambat'])],
                    'notes' => "Loan record #{$i} for {$item->name}"
                ]);
            }
        }
    }
}