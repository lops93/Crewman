<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assignment>
 */
class AssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employment_id' => null,
            'employer_id' => rand(1, 50),
            'title' => $this->faker->catchPhrase,
            'start_date' => Carbon::now(),
            'end_date' => null
        ];
    }
}
