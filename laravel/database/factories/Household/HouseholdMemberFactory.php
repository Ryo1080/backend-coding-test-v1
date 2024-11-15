<?php

namespace Database\Factories\Household;

use App\Models\Household\Household;
use App\Models\Household\HouseholdMember;
use Illuminate\Database\Eloquent\Factories\Factory;

class HouseholdMemberFactory extends Factory
{
    protected $model = HouseholdMember::class;

    public function definition()
    {
        return [
            'household_id' => Household::factory(),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'birthday' => $this->faker->date,
            'relationship' => $this->faker->numberBetween(1, 26),
        ];
    }
}
