<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AssignmentRole>
 */
class AssignmentRoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'assignment_id' =>null,
            'title' => $this->faker->jobTitle,
            'type_id' => rand(1, 2),
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addYears(2)->addDays(rand(0, 730)),
        ];
    }
}
