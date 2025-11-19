<?php

namespace Database\Factories;

use App\Models\QuotationDeliverable;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuotationDeliverableFactory extends Factory
{
    protected $model = QuotationDeliverable::class;

    public function definition()
    {
        return [
            'deliverable_detail' => $this->faker->sentence(6),
        ];
    }
}
