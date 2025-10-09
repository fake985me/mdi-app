<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'name' => 'ABC Corporation',
                'email' => 'contact@abccorp.com',
                'phone' => '+1-555-1001',
                'address' => '789 Business Blvd, Downtown, NY 10001'
            ],
            [
                'name' => 'XYZ Enterprises',
                'email' => 'orders@xyzent.com',
                'phone' => '+1-555-1002',
                'address' => '101 Enterprise Way, Midtown, NY 10002'
            ],
            [
                'name' => 'Global Solutions Ltd',
                'email' => 'info@globalsolutions.com',
                'phone' => '+1-555-1003',
                'address' => '202 Global Street, Uptown, NY 10003'
            ],
            [
                'name' => 'Tech Innovations Inc',
                'email' => 'sales@techinnovations.com',
                'phone' => '+1-555-1004',
                'address' => '303 Innovation Drive, Tech District, NY 10004'
            ],
            [
                'name' => 'John Smith',
                'email' => 'john.smith@example.com',
                'phone' => '+1-555-1005',
                'address' => '404 Personal Address, Suburbia, NY 10005'
            ]
        ];

        foreach ($customers as $customerData) {
            Customer::create($customerData);
        }
    }
}