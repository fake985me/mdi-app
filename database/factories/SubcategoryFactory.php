<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Subcategory>
 */
class SubcategoryFactory extends Factory
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
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'category_id' => Category::factory(), // Create or use an existing category
            'slug' => $this->faker->unique()->slug(),
            'status' => true,
        ];
    }
}