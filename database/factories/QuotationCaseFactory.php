<?php

namespace Database\Factories;

use App\Models\QuotationCase;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuotationCaseFactory extends Factory
{
    protected $model = QuotationCase::class;

    public function definition()
    {
        return [
            'case_title'       => $this->faker->sentence(3),
            'case_description' => $this->faker->sentence(8),
        ];
    }
}
