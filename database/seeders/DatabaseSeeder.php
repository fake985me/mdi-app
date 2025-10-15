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
        // Create users first
        $this->call(UserSeeder::class);
        
        // Create reference data
        $this->call(BrandSeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(CustomerSeeder::class);
        
        // Create categories and products
        $this->call(CategoriesAndSubcategoriesSeeder::class);
        $this->call(ProductsSeeder::class);
        $this->call(DummyProductsSeeder::class); // Add dummy products with images
        
        // Create product-related data
        $this->call(ProductSpecificationSeeder::class);
        $this->call(ProductImageSeeder::class);
        
        // Create business transactions
        $this->call(StockMovementsTableSeeder::class);
        $this->call(PurchasesTableSeeder::class);
        $this->call(SalesTableSeeder::class);
        $this->call(WarrantiesTableSeeder::class);
        $this->call(BorrowingsTableSeeder::class);
        
        // Create transaction items
        $this->call(PurchaseItemsTableSeeder::class);
        $this->call(SaleItemsTableSeeder::class);
        $this->call(WarrantyItemsTableSeeder::class);
        $this->call(BorrowingItemsTableSeeder::class);
        
        // Create orders
        $this->call(OrdersTableSeeder::class);
        
        // Create other data
        $this->call(TemplateSeeder::class);
        $this->call(PagesSeeder::class);
        $this->call(LandingPageSettingsSeeder::class);
        
        // Create home page
        $this->call(HomePageSeeder::class);
    }
}
