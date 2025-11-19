<?php

namespace Database\Factories;

use App\Models\QuotationDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuotationDetailFactory extends Factory
{
    protected $model = QuotationDetail::class;

    public function definition()
    {
        return [
            'item_name'   => $this->faker->word(),
            'description' => $this->faker->sentence(8),
            'quantity'    => $this->faker->numberBetween(1, 3),
            'unit_price'  => $this->faker->randomFloat(2, 250, 1500),
            'total'       => $this->faker->randomFloat(2, 250, 4500),
        ];
    }
}
