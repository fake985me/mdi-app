<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * This seeder is kept for backward compatibility but does nothing since
     * we've moved to using the users table directly with role-based access.
     */
    public function run(): void
    {
        // Profiles table is no longer used - all user data is in the users table
        // This seeder is maintained for migration compatibility but performs no operations
    }
}
