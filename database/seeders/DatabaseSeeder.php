<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Technician;
use App\Models\Quotation;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Example test user
      
        // Call your manager seeder
        $this->call([
            ManagerUserSeeder::class,
            TechnicianUserSeeder::class
        ]);
        Technician::factory()->count(2)->create();

        // 5 customers

        // 20 quotations (customers may repeat, technicians randomly assigned)
        Quotation::factory()->count(20)->create();
    }
}
