<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = (string) env('SEED_CUSTOMER_PASSWORD') ?: Str::random(40);
        User::updateOrCreate(
            ['email' => 'imbaxgx1fromyt@gmail.com'],
            [
                'firstname' => 'Tom German',
                'lastname' => 'Arizobal',
                'password' => Hash::make($password),
                'birthday' => '2005-04-12',
                'role' => 'customer',
            ]
        );
    }
}