<?php

namespace Database\Factories;

use App\Models\WaiverCase;
use Illuminate\Database\Eloquent\Factories\Factory;

class WaiverCaseFactory extends Factory
{
    protected $model = WaiverCase::class;

    public function definition()
    {
        return [
            'case_title'   => $this->faker->sentence(3),
            'description'  => $this->faker->sentence(8),
        ];
    }
}
