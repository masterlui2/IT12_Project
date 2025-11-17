<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

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
    }
}
