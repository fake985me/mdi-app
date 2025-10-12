<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Sale;
use App\Models\Profile;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Sale>
 */
class SaleFactory extends Factory
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
            'customer_name' => $this->faker->name(),
            'customer_contact' => $this->faker->optional()->e164PhoneNumber(),
            'sale_date' => $this->faker->dateTime(),
            'total_amount' => $this->faker->randomFloat(2, 50, 5000),
            'notes' => $this->faker->optional()->sentence(),
            'created_by' => Profile::factory(),
        ];
    }
}