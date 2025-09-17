<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Apple',
                'description' => 'Technology company'
            ],
            [
                'name' => 'Samsung',
                'description' => 'Electronics company'
            ],
            [
                'name' => 'Nike',
                'description' => 'Sportswear company'
            ],
            [
                'name' => 'Adidas',
                'description' => 'Sportswear company'
            ],
            [
                'name' => 'IKEA',
                'description' => 'Furniture retailer'
            ],
            [
                'name' => 'H&M',
                'description' => 'Fashion retailer'
            ],
            [
                'name' => 'Penguin Books',
                'description' => 'Publishing company'
            ],
            [
                'name' => 'Random House',
                'description' => 'Publishing company'
            ]
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(
                ['name' => $brand['name']],
                $brand
            );
        }
    }
}
