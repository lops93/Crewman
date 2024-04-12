<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Leave>
 */
class LeaveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'assignment_id' => null,
            'type' => $this->faker->randomElement(['Sick Leave', 'Vacation', 'Parental Leave', 'Holiday']),
            'start_date' => Carbon::now()->addDays(10), // Example date range for start_date
            'end_date' => Carbon::now()->addDays(rand(20, 30)),    // Example date range for end_date
        ];
    }
}
