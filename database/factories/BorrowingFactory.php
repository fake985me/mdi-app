<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Borrowing;
use App\Models\Product;
use App\Models\Profile;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Borrowing>
 */
class BorrowingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(['active', 'returned', 'overdue']);
        
        return [
            'id' => (string) Str::uuid(),
            'product_id' => Product::factory(),
            'borrower_name' => $this->faker->name(),
            'borrower_contact' => $this->faker->optional()->e164PhoneNumber(),
            'quantity' => $this->faker->numberBetween(1, 10),
            'borrow_date' => $this->faker->dateTimeThisMonth(),
            'expected_return_date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'actual_return_date' => $status === 'returned' ? $this->faker->dateTimeThisMonth() : null,
            'status' => $status,
            'notes' => $this->faker->optional()->sentence(),
            'created_by' => Profile::factory(),
        ];
    }
}