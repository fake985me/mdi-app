<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StockMovement;
use App\Models\Item;
use Carbon\Carbon;

class StockMovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = Item::all();
        
        if ($items->count() > 0) {
            foreach ($items as $item) {
                // Create some stock in movements
                StockMovement::create([
                    'item_id' => $item->id,
                    'type' => StockMovement::TYPE_IN,
                    'quantity' => rand(10, 50),
                    'reference_type' => 'pembelian', // purchase
                    'reference_id' => rand(1, 5), // Simulated purchase ID
                    'date' => Carbon::now()->subDays(rand(1, 30)),
                    'description' => 'Initial stock from purchase'
                ]);
                
                // Create some stock out movements
                StockMovement::create([
                    'item_id' => $item->id,
                    'type' => StockMovement::TYPE_OUT,
                    'quantity' => rand(1, 5),
                    'reference_type' => 'penjualan', // sale
                    'reference_id' => rand(1, 5), // Simulated sale ID
                    'date' => Carbon::now()->subDays(rand(1, 15)),
                    'description' => 'Stock issued for sale'
                ]);
                
                // Create some additional movements
                $movementType = rand(0, 1) ? StockMovement::TYPE_IN : StockMovement::TYPE_OUT;
                $quantity = rand(1, 10);
                
                StockMovement::create([
                    'item_id' => $item->id,
                    'type' => $movementType,
                    'quantity' => $quantity,
                    'reference_type' => $movementType === StockMovement::TYPE_IN ? 'peminjaman' : 'pengembalian', // loan/return
                    'reference_id' => rand(1, 5),
                    'date' => Carbon::now()->subDays(rand(1, 5)),
                    'description' => $movementType === StockMovement::TYPE_IN ? 'Returned item from loan' : 'Item loaned out'
                ]);
            }
        }
    }
}