<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SaleItem;
use App\Models\Sale;
use App\Models\Item;

class SaleItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sales = Sale::all();
        $items = Item::all();
        
        if ($sales->count() > 0 && $items->count() > 0) {
            foreach ($sales as $sale) {
                // Add 1-3 items to each sale
                $itemCount = rand(1, 3);
                
                for ($i = 0; $i < $itemCount; $i++) {
                    $item = $items->random();
                    $quantity = rand(1, 5);
                    $price = $item->price ?: (rand(1000, 5000) / 10); // Use item price or random price
                    $subtotal = $quantity * $price;
                    
                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'item_id' => $item->id,
                        'quantity' => $quantity,
                        'price' => $price,
                        'subtotal' => $subtotal
                    ]);
                }
            }
        }
    }
}