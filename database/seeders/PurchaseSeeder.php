<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Purchase;
use App\Models\Supplier;
use Carbon\Carbon;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = Supplier::all();
        
        if ($suppliers->count() > 0) {
            for ($i = 1; $i <= 5; $i++) {
                $supplier = $suppliers->random();
                
                Purchase::create([
                    'purchase_number' => 'PUR-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                    'supplier_id' => $supplier->id,
                    'date' => Carbon::now()->subDays(rand(1, 60)),
                    'total' => rand(1000, 10000) / 10, // Convert to decimal
                    'notes' => "Purchase order #{$i} from {$supplier->name}"
                ]);
            }
        }
    }
}