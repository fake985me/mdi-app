<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Tech Distributors Inc.',
                'email' => 'contact@techdistributors.com',
                'phone' => '+1-555-0123',
                'address' => '123 Tech Street, Silicon Valley, CA 94000'
            ],
            [
                'name' => 'Furniture Wholesale Co.',
                'email' => 'orders@furniturewholesale.com',
                'phone' => '+1-555-0456',
                'address' => '456 Wood Avenue, Portland, OR 97000'
            ],
            [
                'name' => 'Global Electronics Ltd',
                'email' => 'sales@globalelectronics.com',
                'phone' => '+1-555-0789',
                'address' => '789 Circuit Road, Austin, TX 78700'
            ],
            [
                'name' => 'Office Solutions Inc.',
                'email' => 'info@officesolutions.com',
                'phone' => '+1-555-0012',
                'address' => '321 Stationery Lane, Chicago, IL 60600'
            ]
        ];

        foreach ($suppliers as $supplierData) {
            Supplier::create($supplierData);
        }
    }
}