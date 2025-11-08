<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\SuccessRating;

class SuccessRatingSeeder extends Seeder
{
    public function run(): void
    {
        $school = School::first();

        if ($school) {
            SuccessRating::create([
                'schoolID' => $school->id,
                'year' => 2024,
                'success_rate' => 85.5,
                'notes' => 'Good performance overall',
            ]);

            SuccessRating::create([
                'schoolID' => $school->id,
                'year' => 2023,
                'success_rate' => 82.3,
                'notes' => 'Steady improvement',
            ]);
        }
    }
}
