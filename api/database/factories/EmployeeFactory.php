<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $generateNumber = $this->faker->unique()->numberBetween(10000, 99999);
        $identificationNumber = 'ZID' . $generateNumber;

        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'identification_number' => $identificationNumber,
        ];
    }
}
