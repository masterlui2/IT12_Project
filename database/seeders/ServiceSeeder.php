<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Computer / Laptop Repair',
                'description' => 'Diagnosis and repair for desktops and laptops, including hardware and software issues.',
                'diagnostic_fee' => 500.00, // Fixed price for this service
            ],
            [
                'name' => 'Networking',
                'description' => 'Setup, troubleshooting, and maintenance of wired and wireless networks.',
                'diagnostic_fee' => 500.00, // Fixed price
            ],
            [
                'name' => 'Printer Repair',
                'description' => 'Repair services for various printer types, resolving mechanical and connectivity problems.',
                'diagnostic_fee' => 500.00, // Fixed price
            ],
            [
                'name' => 'CCTV Installation / Repair',
                'description' => 'Installation, configuration, and repair of Closed-Circuit Television systems.',
                'diagnostic_fee' => 500.00, // Fixed price
            ],
            [
                'name' => 'Aircon Cleaning / Repair',
                'description' => 'Cleaning, maintenance, and repair services for air conditioning units.',
                'diagnostic_fee' => 500.00, // Fixed price
            ],
            [
                'name' => 'Data Recovery',
                'description' => 'Retrieval of lost or corrupted data from various storage devices.',
                'diagnostic_fee' => 500.00, // Fixed price, higher due to complexity
            ],
            [
                'name' => 'Software Installation & Setup',
                'description' => 'Installation and configuration of operating systems and application software.',
                'diagnostic_fee' => 500.00, // Fixed price
            ],
            [
                'name' => 'Other',
                'description' => 'For services not explicitly listed, requiring custom assessment.',
                'diagnostic_fee' => 500.00, // Default diagnostic fee for 'Other'
            ],
        ];

        foreach ($services as $serviceData) {
            Service::create($serviceData);
        }
    }
}
