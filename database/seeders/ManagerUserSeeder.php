<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ManagerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'manager@gmail.com'],  // lookup
            [
                'firstname' => 'Manager',
                'lastname' => 'User',
                'password' => Hash::make('manager'), // change this
                'birthday' => '2005-04-12', // change this
                'role' => 'manager', // requires you added this column
            ]
        );
    }
}
