<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Purchase;
use App\Models\Profile;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Purchase>
 */
class PurchaseFactory extends Factory
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
            'supplier_name' => $this->faker->company(),
            'supplier_contact' => $this->faker->optional()->e164PhoneNumber(),
            'purchase_date' => $this->faker->dateTime(),
            'total_amount' => $this->faker->randomFloat(2, 100, 10000),
            'notes' => $this->faker->optional()->sentence(),
            'created_by' => Profile::factory(),
        ];
    }
}