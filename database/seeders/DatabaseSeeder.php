<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run the permission migrations first if they haven't been published yet
        $this->call([
            PermissionSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            SubcategorySeeder::class,
            BrandSeeder::class,
            ItemSeeder::class,
            ItemImageSeeder::class,
            SupplierSeeder::class,
            CustomerSeeder::class,
            StockMovementSeeder::class,
            PurchaseSeeder::class,
            PurchaseItemSeeder::class,
            SaleSeeder::class,
            SaleItemSeeder::class,
            LoanSeeder::class,
            ReturnSeeder::class,
            ReturnRecordSeeder::class,
            WarrantySeeder::class,
            PageSettingSeeder::class,
        ]);
    }
}