<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['name' => 'Apple', 'description' => 'American multinational technology company'],
            ['name' => 'Samsung', 'description' => 'South Korean multinational electronics company'],
            ['name' => 'Dell', 'description' => 'American multinational technology company'],
            ['name' => 'HP', 'description' => 'American multinational information technology company'],
            ['name' => 'Lenovo', 'description' => 'Chinese multinational technology company'],
            ['name' => 'Asus', 'description' => 'Taiwanese multinational computer hardware company'],
            ['name' => 'Acer', 'description' => 'Taiwanese computer technology company'],
            ['name' => 'Microsoft', 'description' => 'American multinational technology company'],
            ['name' => 'Sony', 'description' => 'Japanese multinational conglomerate'],
            ['name' => 'LG', 'description' => 'South Korean multinational electronics company'],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}