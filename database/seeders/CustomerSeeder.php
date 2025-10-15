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
                'name' => 'PT. Maju Jaya',
                'phone' => '021-11111111',
                'email' => 'info@majujaya.com',
                'address' => 'Jl. Niaga No. 1, Jakarta',
                'notes' => 'Regular corporate customer'
            ],
            [
                'name' => 'CV. Cemerlang Abadi',
                'phone' => '021-22222222',
                'email' => 'cs@cemerlang.com',
                'address' => 'Jl. Perdagangan No. 2, Bandung',
                'notes' => 'Long-term customer with good credit'
            ],
            [
                'name' => 'UD. Sumber Rejeki',
                'phone' => '021-33333333',
                'email' => 'rejeki@sumber.com',
                'address' => 'Jl. Usaha No. 3, Surabaya',
                'notes' => 'Frequent buyer of electronics'
            ],
            [
                'name' => 'Ibu Siti',
                'phone' => '021-44444444',
                'email' => 'siti.h@gmail.com',
                'address' => 'Jl. Mawar No. 4, Medan',
                'notes' => 'Individual customer'
            ],
            [
                'name' => 'Bapak Andi',
                'phone' => '021-55555555',
                'email' => 'andi.kurniawan@yahoo.com',
                'address' => 'Jl. Melati No. 5, Yogyakarta',
                'notes' => 'Preferred individual customer'
            ],
            [
                'name' => 'PT. Inovasi Digital',
                'phone' => '021-66666666',
                'email' => 'it@inovasidigital.com',
                'address' => 'Jl. IT No. 6, Jakarta Selatan',
                'notes' => 'IT solutions customer'
            ],
            [
                'name' => 'Toko Serba Ada',
                'phone' => '021-77777777',
                'email' => 'toko@serbaada.com',
                'address' => 'Jl. Dagang No. 7, Semarang',
                'notes' => 'Retail customer'
            ],
            [
                'name' => 'Universitas Harapan Bangsa',
                'phone' => '021-88888888',
                'email' => 'procurement@univ-hb.ac.id',
                'address' => 'Jl. Pendidikan No. 8, Depok',
                'notes' => 'Educational institution'
            ]
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}