<?php

namespace Database\Factories;

use App\Models\QuotationWaiver;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuotationWaiverFactory extends Factory
{
    protected $model = QuotationWaiver::class;

    public function definition()
    {
        return [
            'waiver_title'       => $this->faker->sentence(3),
            'waiver_description' => $this->faker->sentence(10),
        ];
    }
}
