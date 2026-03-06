<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'firstname' => 'Admin',
                'lastname' => 'User',
                'password' => Hash::make('Admin@2003'),
                'birthday' => '2005-04-12',
                'role' => 'admin',
            ]
        );
    }
}