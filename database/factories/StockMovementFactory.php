<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\StockMovement;
use App\Models\Product;
use App\Models\Profile;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<StockMovement>
 */
class StockMovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $movementType = $this->faker->randomElement(['incoming', 'outgoing', 'purchase', 'sale', 'borrow', 'return']);
        
        return [
            'id' => (string) Str::uuid(),
            'product_id' => Product::factory(),
            'movement_type' => $movementType,
            'quantity' => $this->faker->numberBetween(1, 100),
            'unit_price' => $this->faker->randomFloat(2, 10, 500),
            'total_amount' => $this->faker->randomFloat(2, 10, 10000),
            'notes' => $this->faker->optional()->sentence(),
            'created_by' => Profile::factory(),
        ];
    }
}