<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warranty;
use App\Models\Item;
use Carbon\Carbon;

class WarrantySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = Item::all();
        
        if ($items->count() > 0) {
            foreach ($items as $index => $item) {
                // Create warranty for about half of the items
                if ($index % 2 === 0) {
                    $startDate = Carbon::now()->subMonths(rand(1, 24)); // Within last 2 years
                    $warrantyMonths = [6, 12, 24, 36][array_rand([6, 12, 24, 36])]; // 6, 12, 24, or 36 months
                    $endDate = $startDate->copy()->addMonths($warrantyMonths);
                    
                    Warranty::create([
                        'item_id' => $item->id,
                        'warranty_number' => 'WRT-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                        'terms' => 'Standard manufacturer warranty covering defects in materials and workmanship',
                        'status' => $endDate->isPast() ? 'kadaluarsa' : 'aktif', // expired if end date is in the past
                        'notes' => "Warranty for {$item->name}"
                    ]);
                }
            }
        }
    }
}