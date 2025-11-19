<?php

namespace Database\Factories;

use App\Models\Technician;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TechnicianFactory extends Factory
{
    protected $model = Technician::class;

    public function definition()
    {
        $user = User::factory()->create(['role' => 'technician']);

        return [
            'user_id' => $user->id,
            'specialization' => $this->faker->randomElement(['Hardware', 'Software', 'Network']),
            'certifications' => $this->faker->randomElement(['TESDA NC II', 'CompTIA A+', 'Cisco CCNA']),
        ];
    }
}
