<?php

namespace Database\Seeders;

use App\Models\AssignmentRoleType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssignmentRoleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleTypes = ['Qualification', 'Position'];

        foreach ($roleTypes as $roleType) {
            AssignmentRoleType::create([
                'title' => $roleType,
            ]);
        }
    }
}
