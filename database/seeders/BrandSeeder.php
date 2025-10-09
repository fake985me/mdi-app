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
            [
                'name' => 'Apple',
                'description' => 'Technology company specializing in consumer electronics, software, and services'
            ],
            [
                'name' => 'Samsung',
                'description' => 'South Korean multinational electronics corporation'
            ],
            [
                'name' => 'Dell',
                'description' => 'American multinational computer technology company'
            ],
            [
                'name' => 'IKEA',
                'description' => 'Swedish furniture company'
            ],
            [
                'name' => 'HP',
                'description' => 'American multinational information technology company'
            ],
            [
                'name' => 'Nike',
                'description' => 'American multinational corporation that designs and sells athletic footwear'
            ],
            [
                'name' => 'Adidas',
                'description' => 'German multinational corporation that designs and manufactures shoes'
            ]
        ];

        foreach ($brands as $brandData) {
            Brand::create([
                'name' => $brandData['name'],
                'description' => $brandData['description'],
            ]);
        }
    }
}