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
                'firstname' => 'Red Xavier',
                'lastname' => 'Rodrigo',
                'password' => Hash::make('12345678'), // change this
                'birthday' => '2005-04-12', // change this
                'role' => 'technician', // requires you added this column
            ]
        );
    }
}
