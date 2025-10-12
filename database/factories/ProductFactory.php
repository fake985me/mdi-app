<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'sku' => $this->faker->unique()->ean13(),
            'category_id' => Category::factory(),
            'subcategory_id' => Subcategory::factory(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'cost_price' => $this->faker->randomFloat(2, 5, 500),
            'current_stock' => $this->faker->numberBetween(0, 100),
            'minimum_stock' => $this->faker->numberBetween(0, 10),
            'maximum_stock' => $this->faker->numberBetween(50, 200),
            'image_url' => $this->faker->imageUrl(),
            'status' => true,
        ];
    }
}