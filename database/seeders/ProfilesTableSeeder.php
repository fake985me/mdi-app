<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an admin user profile if it doesn't exist
        if (!\App\Models\Profile::where('email', 'admin@example.com')->exists()) {
            \App\Models\Profile::create([
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'email' => 'admin@example.com',
                'full_name' => 'Admin User',
                'role' => 'admin',
                'permissions' => null,
            ]);
        }

        // Create a regular user profile if it doesn't exist
        if (!\App\Models\Profile::where('email', 'user@example.com')->exists()) {
            \App\Models\Profile::create([
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'email' => 'user@example.com',
                'full_name' => 'Regular User',
                'role' => 'user',
                'permissions' => null,
            ]);
        }

        // Create a superadmin user profile if it doesn't exist
        if (!\App\Models\Profile::where('email', 'superadmin@example.com')->exists()) {
            \App\Models\Profile::create([
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'email' => 'superadmin@example.com',
                'full_name' => 'Super Admin',
                'role' => 'superadmin',
                'permissions' => null,
            ]);
        }
    }
}
