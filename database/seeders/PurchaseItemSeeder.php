<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseItem;
use App\Models\Purchase;
use App\Models\Item;

class PurchaseItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $purchases = Purchase::all();
        $items = Item::all();
        
        if ($purchases->count() > 0 && $items->count() > 0) {
            foreach ($purchases as $purchase) {
                // Add 1-3 items to each purchase
                $itemCount = rand(1, 3);
                
                for ($i = 0; $i < $itemCount; $i++) {
                    $item = $items->random();
                    $quantity = rand(5, 20);
                    $price = rand(1000, 5000) / 10; // Convert to decimal
                    $subtotal = $quantity * $price;
                    
                    PurchaseItem::create([
                        'purchase_id' => $purchase->id,
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