<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Order>
 */
class OrderFactory extends Factory
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
            'user_id' => User::factory(),
            'order_number' => $this->faker->unique()->ean13(),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'shipped', 'delivered', 'cancelled']),
            'total_amount' => $this->faker->randomFloat(2, 100, 5000),
            'shipping_address' => [
                'street' => $this->faker->streetAddress(),
                'city' => $this->faker->city(),
                'state' => $this->faker->state(),
                'zip' => $this->faker->postcode(),
                'country' => $this->faker->country(),
            ],
            'billing_address' => [
                'street' => $this->faker->streetAddress(),
                'city' => $this->faker->city(),
                'state' => $this->faker->state(),
                'zip' => $this->faker->postcode(),
                'country' => $this->faker->country(),
            ],
            'payment_method' => $this->faker->randomElement(['credit_card', 'paypal', 'bank_transfer', 'cash_on_delivery']),
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'failed', 'refunded']),
        ];
    }
}