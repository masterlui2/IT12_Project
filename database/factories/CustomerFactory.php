<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition()
    {
        // Link each customer to a new user with role='customer'
        $user = User::factory()->create(['role' => 'customer']);

        return [
            'user_id' => $user->id,
            'company_name' => $this->faker->company(),
            'address' => $this->faker->address(),
            'contact_number' => $this->faker->phoneNumber(),
            'tin_number' => $this->faker->numerify('###-###-###'),
        ];
    }
}
