<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Profile>
 */
class ProfileFactory extends Factory
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
            'full_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'role' => $this->faker->randomElement(['superadmin', 'admin', 'user']),
            'permissions' => null,
        ];
    }
}