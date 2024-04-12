<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Location;
use App\Models\Employment;
use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employments = Employment::all();

        foreach ($employments as $employment) {
            // Insert a new assignment role with the employment_id set to the employment's id
            $assignment = Assignment::factory()->create([
                'employment_id' => $employment->id,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addYears(2)->addDays(rand(0, 730)),
            ]);
            DB::table('assignment_location')->insert([
                'assignment_id' => $assignment->id,
                'location_id' => rand(1, 193)
            ]);
            Leave::factory()->create([
                'assignment_id' => $assignment->id,
            ]);
        }
    }
}
