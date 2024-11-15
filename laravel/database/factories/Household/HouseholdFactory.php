<?php

namespace Database\Factories\Household;

use App\Models\Household\Household;
use Illuminate\Database\Eloquent\Factories\Factory;

class HouseholdFactory extends Factory
{
    protected $model = Household::class;

    public function definition()
    {
        return [
            'phone_number' => $this->faker->numerify('###########'),
            'email' => $this->faker->safeEmail,
            'postal_code' => $this->faker->postcode,
            'address' => $this->faker->address,
        ];
    }
}
