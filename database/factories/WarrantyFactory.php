<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Warranty;
use App\Models\Product;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Warranty>
 */
class WarrantyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeThisYear();
        $endDate = $this->faker->dateTimeBetween($startDate, '+2 years');
        
        return [
            'id' => (string) Str::uuid(),
            'product_id' => Product::factory(),
            'warranty_start_date' => $startDate,
            'warranty_end_date' => $endDate,
            'warranty_terms' => $this->faker->optional()->paragraph(),
            'customer_name' => $this->faker->name(),
            'customer_contact' => $this->faker->optional()->e164PhoneNumber(),
        ];
    }
}