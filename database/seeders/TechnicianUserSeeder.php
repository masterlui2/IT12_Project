<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TechnicianUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = (string) env('SEED_TECHNICIAN_PASSWORD') ?: Str::random(40);
        User::updateOrCreate(
            ['email' => 'technician@gmail.com'],
            [
                'firstname' => 'Red Xavier',
                'lastname' => 'Rodrigo',
                'password' => Hash::make($password),
                'birthday' => '2005-04-12',
                'role' => 'technician',
            ]
        );
    }
}
