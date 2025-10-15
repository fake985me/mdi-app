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
                'name' => 'Tech Supplies Co.',
                'contact_person' => 'John Smith',
                'phone' => '021-12345678',
                'email' => 'contact@tech-supplies.com',
                'address' => 'Jl. Teknologi No. 123, Jakarta',
                'notes' => 'Main supplier for electronic components'
            ],
            [
                'name' => 'Global Electronics',
                'contact_person' => 'Maria Garcia',
                'phone' => '021-87654321',
                'email' => 'info@globalelectronics.com',
                'address' => 'Jl. Komputer No. 456, Bandung',
                'notes' => 'Specialized in computer hardware'
            ],
            [
                'name' => 'Office Solutions Ltd',
                'contact_person' => 'Robert Johnson',
                'phone' => '021-11223344',
                'email' => 'sales@officesolutions.com',
                'address' => 'Jl. Perkantoran No. 789, Surabaya',
                'notes' => 'Office equipment supplier'
            ],
            [
                'name' => 'Premium Devices Inc',
                'contact_person' => 'Emily Chen',
                'phone' => '021-55667788',
                'email' => 'orders@premiumdevices.com',
                'address' => 'Jl. Gadget No. 321, Medan',
                'notes' => 'High-end electronics supplier'
            ],
            [
                'name' => 'Budget Tech Solutions',
                'contact_person' => 'Ahmad Yusuf',
                'phone' => '021-99887766',
                'email' => 'support@budgettech.com',
                'address' => 'Jl. Teknologi Murah No. 654, Makassar',
                'notes' => 'Affordable tech solutions'
            ]
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}