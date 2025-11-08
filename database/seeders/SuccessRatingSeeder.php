<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\Grade;
use App\Models\SuccessRating;

class SuccessRatingSeeder extends Seeder
{
    public function run(): void
    {
        $school = School::first();
        $grade = Grade::first();

        if ($school && $grade) {
            SuccessRating::create([
                'schoolID' => $school->id,
                'gradeID' => $grade->id,
                'total_students' => 100,
                'A' => 20,
                'B' => 35,
                'C' => 30,
                'D' => 15,
            ]);

            SuccessRating::create([
                'schoolID' => $school->id,
                'gradeID' => $grade->id,
                'total_students' => 95,
                'A' => 25,
                'B' => 30,
                'C' => 28,
                'D' => 12,
            ]);
        }
    }
}
