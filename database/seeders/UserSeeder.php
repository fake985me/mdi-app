<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a superadmin user if it doesn't exist
        if (!User::where('email', 'superadmin@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('password'),
                'role' => 'superadmin',
            ]);
        }

        // Create an admin user if it doesn't exist
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
        }

        // Create a regular user if it doesn't exist
        if (!User::where('email', 'user@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);
        }

        // Create additional users for testing if they don't already exist
        $existingUserCount = User::count();
        $usersToCreate = max(0, 13 - $existingUserCount); // Total of 13 users (3 base + 10 more)
        
        if ($usersToCreate > 0) {
            User::factory($usersToCreate)->create();
        }
    }
}