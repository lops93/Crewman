<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Employment;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmploymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::factory(100)->create()->each(function ($employee) {

            // Create past employment for the employee
            Employment::factory()->create([
                'employee_id' => $employee->id,
                'start_date' => Carbon::now()->subYears(2)->subDays(rand(1, 365)) ,
                'end_date' => Carbon::now()->subYears(1)->addDays(rand(1, 365)),
            ]);

            // Create current employment for the employee
            Employment::factory()->create([
                'employee_id' => $employee->id,
                'start_date' => Carbon::now(),
                'end_date' => null,
            ]);

            // Create future employment for the employee
            Employment::factory()->create([
                'employee_id' => $employee->id,
                'start_date' => Carbon::now()->addYears(2)->addDays(rand(0, 730)),
                'end_date' => null,
            ]);
        });
    }
}
