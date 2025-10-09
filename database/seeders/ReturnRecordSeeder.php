<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReturnRecord;
use App\Models\Loan;
use Carbon\Carbon;

class ReturnRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $loans = Loan::whereNotNull('return_date')->get();
        
        if ($loans->count() > 0) {
            foreach ($loans as $loan) {
                ReturnRecord::create([
                    'loan_id' => $loan->id,
                    'return_date' => Carbon::now()->subDays(rand(1, 10)),
                    'condition' => ['Good', 'Fair', 'Poor'][array_rand(['Good', 'Fair', 'Poor'])],
                    'notes' => "Return record for loan #{$loan->id}"
                ]);
            }
        }
    }
}