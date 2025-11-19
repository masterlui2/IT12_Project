<?php

namespace Database\Factories;

use App\Models\Quotation;
use App\Models\Customer;
use App\Models\Technician;
use App\Models\QuotationDetail;
use App\Models\QuotationScope;
use App\Models\QuotationCase;
use App\Models\QuotationWaiver;
use App\Models\WaiverCase;
use App\Models\QuotationDeliverable;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuotationFactory extends Factory
{
    protected $model = Quotation::class;

    public function definition()
    {
        return [
            'customer_id' => Customer::inRandomOrder()->first()->id,
            'technician_id' => Technician::inRandomOrder()->first()->id,
            'client_name' => $this->faker->company(),
            'client_address' => $this->faker->address(),
            'project_title' => $this->faker->sentence(3),
            'date_issued' => $this->faker->date(),
            'objective' => $this->faker->paragraph(),
            'timeline_min_days' => $this->faker->numberBetween(5, 10),
            'timeline_max_days' => $this->faker->numberBetween(10, 20),
            'terms_conditions' => $this->faker->sentence(12),
            'labor_estimate' => $this->faker->randomFloat(2, 1000, 4000),
            'diagnostic_fee' => $this->faker->randomFloat(2, 100, 400),
            'grand_total' => $this->faker->randomFloat(2, 1500, 5000),
            'status' => 'draft',
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Quotation $quotation) {
            // Create details
            QuotationDetail::factory()->count(rand(2, 5))->create(['quotation_id' => $quotation->id]);

            // Scopes and nested cases
            $scopes = QuotationScope::factory()->count(rand(1, 3))->create(['quotation_id' => $quotation->id]);
            foreach ($scopes as $scope) {
                QuotationCase::factory()->count(rand(1, 3))->create(['scope_id' => $scope->id]);
            }

            // Waivers and nested cases
            $waivers = QuotationWaiver::factory()->count(rand(1, 2))->create(['quotation_id' => $quotation->id]);
            foreach ($waivers as $waiver) {
                WaiverCase::factory()->count(rand(1, 3))->create(['waiver_id' => $waiver->id]);
            }

            // Deliverables
            QuotationDeliverable::factory()->count(rand(2, 4))->create(['quotation_id' => $quotation->id]);
        });
    }
}
