<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductSpecification;
use App\Models\Product;

class ProductSpecificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        
        foreach ($products as $product) {
            $specifications = [
                ['spec_name' => 'Processor', 'spec_value' => 'Intel Core i5', 'sort_order' => 1],
                ['spec_name' => 'RAM', 'spec_value' => '8GB DDR4', 'sort_order' => 2],
                ['spec_name' => 'Storage', 'spec_value' => '256GB SSD', 'sort_order' => 3],
                ['spec_name' => 'Screen Size', 'spec_value' => '15.6 inches', 'sort_order' => 4],
                ['spec_name' => 'Resolution', 'spec_value' => '1920 x 1080', 'sort_order' => 5],
                ['spec_name' => 'Operating System', 'spec_value' => 'Windows 11', 'sort_order' => 6],
                ['spec_name' => 'Weight', 'spec_value' => '1.8 kg', 'sort_order' => 7],
                ['spec_name' => 'Battery Life', 'spec_value' => '8 hours', 'sort_order' => 8],
            ];

            foreach ($specifications as $spec) {
                // Randomly assign some specs to products
                if (rand(0, 1)) {
                    ProductSpecification::create([
                        'product_id' => $product->id,
                        'spec_name' => $spec['spec_name'],
                        'spec_value' => $spec['spec_value'],
                        'sort_order' => $spec['sort_order'],
                    ]);
                }
            }
        }
    }
}