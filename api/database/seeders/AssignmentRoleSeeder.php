<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\AssignmentRole;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssignmentRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assignments = Assignment::all();

        foreach ($assignments as $assignment) {
            // Insert a new assignment role with the employment_id set to the employment's id
            AssignmentRole::factory(3)->create([
                'assignment_id' => $assignment->id,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addYears(2)->addDays(rand(0, 730)),
            ]);
        }
    }
}
