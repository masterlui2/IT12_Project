<?php

namespace Database\Factories;

use App\Models\QuotationScope;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuotationScopeFactory extends Factory
{
    protected $model = QuotationScope::class;

    public function definition()
    {
        return [
            'scenario_name' => $this->faker->sentence(3),
            'description'   => $this->faker->paragraph(1),
        ];
    }
}
