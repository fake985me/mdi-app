<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductImage;
use App\Models\Product;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        
        foreach ($products as $product) {
            $imagePaths = [
                'https://via.placeholder.com/300x300.png?text=Product+Image+1',
                'https://via.placeholder.com/300x300.png?text=Product+Image+2',
                'https://via.placeholder.com/300x300.png?text=Product+Image+3',
                'https://via.placeholder.com/300x300.png?text=Product+Image+4',
            ];
            
            foreach ($imagePaths as $index => $path) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'sort_order' => $index,
                    'is_primary' => $index === 0, // First image is primary
                ]);
            }
        }
    }
}