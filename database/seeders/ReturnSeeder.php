<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Return;
use App\Models\Loan;
use Carbon\Carbon;

class ReturnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $loans = Loan::where('status', 'dikembalikan')->get();
        
        if ($loans->count() > 0) {
            foreach ($loans as $loan) {
                Return::create([
                    'loan_id' => $loan->id,
                    'return_date' => Carbon::now()->subDays(rand(1, 10)),
                    'condition' => ['Baik', 'Rusak Ringan', 'Rusak Berat'][array_rand(['Baik', 'Rusak Ringan', 'Rusak Berat'])],
                    'notes' => "Item returned from loan #{$loan->id}"
                ]);
            }
        }
    }
}