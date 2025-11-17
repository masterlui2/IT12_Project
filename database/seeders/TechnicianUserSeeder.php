<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TechnicianUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'technician@gmail.com'],  // lookup
            [
                'name' => 'Red Xavier',
                'password' => Hash::make('123456'), // change this
                'role' => 'technician', // requires you added this column
            ]
        );
    }
}
