<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ManagerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = (string) env('SEED_MANAGER_PASSWORD') ?: Str::random(40);
        User::updateOrCreate(
            ['email' => 'manager@gmail.com'],
            [
                'firstname' => 'Manager',
                'lastname' => 'User',
                'password' => Hash::make($password),
                'birthday' => '2005-04-12',
                'role' => 'manager',
            ]
        );
    }
}
