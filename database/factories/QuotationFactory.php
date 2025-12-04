<?php

namespace Database\Factories;
use App\Models\Quotation;
use App\Models\Customer;
use App\Models\Technician;
use App\Models\QuotationDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuotationFactory extends Factory
{
    protected $model = Quotation::class;

    public function definition()
    {
        $customer = Customer::first() ?? Customer::factory()->create();
        $technician = Technician::first() ?? Technician::factory()->create();

        return [
            'customer_id' => $customer->id,
            'technician_id' => $technician->id,
            'project_title' => $this->faker->sentence(3),
            'date_issued' => now(),
            'objective' => $this->faker->paragraph(2),
            'timeline_min_days' => 3,
            'timeline_max_days' => 7,
            'terms_conditions' => $this->faker->sentence(10),
            'labor_estimate' => 2500,
            'diagnostic_fee' => 300,
            'grand_total' => 2800,
            'status' => 'draft',
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Quotation $quotation) {
            QuotationDetail::factory()->count(3)->create([
                'quotation_id' => $quotation->id
            ]);
        });
    }
}
