<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ItemImage;
use App\Models\Item;

class ItemImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some sample images for items
        $items = Item::all();
        
        if ($items->count() > 0) {
            foreach ($items as $index => $item) {
                // Create 1-3 images for each item
                $imageCount = rand(1, 3);
                
                for ($i = 0; $i < $imageCount; $i++) {
                    ItemImage::create([
                        'item_id' => $item->id,
                        'image_path' => "items/{$item->code}_{$i+1}.jpg",
                        'is_primary' => $i === 0, // First image is primary
                        'order_position' => $i + 1
                    ]);
                }
            }
        }
    }
}