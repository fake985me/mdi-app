<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a test user only if it doesn't exist
        if (!\App\Models\User::where('email', 'test@example.com')->exists()) {
            \App\Models\User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'role' => 'superadmin',
            ]);
        }
        
        $this->call(ProfilesTableSeeder::class);
        $this->call(CategoriesAndSubcategoriesSeeder::class);
        $this->call(ProductsSeeder::class);
        $this->call(DummyProductsSeeder::class); // Add dummy products with images
        $this->call(StockMovementsTableSeeder::class);
        $this->call(PurchasesTableSeeder::class);
        $this->call(SalesTableSeeder::class);
        $this->call(WarrantiesTableSeeder::class);
        $this->call(BorrowingsTableSeeder::class);
    }
}
