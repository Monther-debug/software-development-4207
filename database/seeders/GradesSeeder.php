<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\Grade;

class GradesSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure a school exists
        $school = School::first() ?? School::create([
            'name' => 'Seed School',
            'address' => '100 Seed Ave',
            'status' => 'active',
            'type' => 'public',
            'level' => 'secondary',
        ]);

        $grades = [
            [ 'school_id' => $school->id, 'name' => 'Grade 1', 'code' => 'G1', 'status' => 'active' ],
            [ 'school_id' => $school->id, 'name' => 'Grade 2', 'code' => 'G2', 'status' => 'active' ],
            [ 'school_id' => $school->id, 'name' => 'Grade 3', 'code' => 'G3', 'status' => 'active' ],
        ];

        foreach ($grades as $data) {
            Grade::firstOrCreate([
                'school_id' => $data['school_id'],
                'code' => $data['code'],
            ], $data);
        }
    }
}
