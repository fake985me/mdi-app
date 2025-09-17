<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some categories, subcategories, and brands
        $electronics = Category::where('name', 'Electronics')->first();
        $furniture = Category::where('name', 'Furniture')->first();
        $clothing = Category::where('name', 'Clothing')->first();
        $books = Category::where('name', 'Books')->first();
        $sports = Category::where('name', 'Sports')->first();

        $smartphones = Subcategory::where('name', 'Smartphones')->first();
        $laptops = Subcategory::where('name', 'Laptops')->first();
        $livingRoom = Subcategory::where('name', 'Living Room')->first();
        $menClothing = Subcategory::where('name', 'Men')->first();
        $fiction = Subcategory::where('name', 'Fiction')->first();

        $apple = Brand::where('name', 'Apple')->first();
        $samsung = Brand::where('name', 'Samsung')->first();
        $ikea = Brand::where('name', 'IKEA')->first();
        $nike = Brand::where('name', 'Nike')->first();
        $penguin = Brand::where('name', 'Penguin Books')->first();

        $products = [
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'Latest iPhone with advanced camera system',
                'specifications' => [
                    'storage' => '128GB',
                    'color' => 'Space Black',
                    'screen_size' => '6.1 inches'
                ],
                'sku' => 'IP15PRO-128-BLK',
                'price' => 999.99,
                'stock_quantity' => 50,
                'category_id' => $electronics->id,
                'subcategory_id' => $smartphones->id,
                'brand_id' => $apple->id
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'description' => 'Flagship Android smartphone',
                'specifications' => [
                    'storage' => '256GB',
                    'color' => 'Phantom Black',
                    'screen_size' => '6.2 inches'
                ],
                'sku' => 'S24-256-BLK',
                'price' => 899.99,
                'stock_quantity' => 30,
                'category_id' => $electronics->id,
                'subcategory_id' => $smartphones->id,
                'brand_id' => $samsung->id
            ],
            [
                'name' => 'MacBook Air M2',
                'description' => 'Lightweight laptop with M2 chip',
                'specifications' => [
                    'storage' => '256GB SSD',
                    'ram' => '8GB',
                    'processor' => 'Apple M2'
                ],
                'sku' => 'MBA-M2-256',
                'price' => 1199.99,
                'stock_quantity' => 25,
                'category_id' => $electronics->id,
                'subcategory_id' => $laptops->id,
                'brand_id' => $apple->id
            ],
            [
                'name' => 'IKEA EKTORP Sofa',
                'description' => 'Comfortable 3-seat sofa',
                'specifications' => [
                    'color' => 'Beige',
                    'material' => 'Fabric',
                    'dimensions' => '88x213x88 cm'
                ],
                'sku' => 'EK-SOFA-BEIGE',
                'price' => 499.99,
                'stock_quantity' => 15,
                'category_id' => $furniture->id,
                'subcategory_id' => $livingRoom->id,
                'brand_id' => $ikea->id
            ],
            [
                'name' => 'Nike Air Max 270',
                'description' => 'Comfortable running shoes',
                'specifications' => [
                    'size' => 'US 10',
                    'color' => 'Black/White',
                    'material' => 'Mesh'
                ],
                'sku' => 'NIKE-AM270-BK',
                'price' => 129.99,
                'stock_quantity' => 100,
                'category_id' => $clothing->id,
                'subcategory_id' => $menClothing->id,
                'brand_id' => $nike->id
            ],
            [
                'name' => 'The Great Gatsby',
                'description' => 'Classic American novel by F. Scott Fitzgerald',
                'specifications' => [
                    'author' => 'F. Scott Fitzgerald',
                    'pages' => '180',
                    'language' => 'English'
                ],
                'sku' => 'GATSBY-PENGUIN',
                'price' => 12.99,
                'stock_quantity' => 200,
                'category_id' => $books->id,
                'subcategory_id' => $fiction->id,
                'brand_id' => $penguin->id
            ]
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['sku' => $product['sku']],
                $product
            );
        }
    }
}
