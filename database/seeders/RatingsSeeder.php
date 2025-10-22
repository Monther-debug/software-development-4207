<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\Teacher;
use App\Models\Rating;

class RatingsSeeder extends Seeder
{
    public function run(): void
    {
        $school = School::first();
        $teacher = Teacher::first();

        if ($school) {
            foreach ([5, 4] as $score) {
                Rating::create([
                    'rateable_type' => School::class,
                    'rateable_id' => $school->id,
                    'author' => 'Seeder',
                    'score' => $score,
                    'note' => 'School rating seed',
                ]);
            }
        }

        if ($teacher) {
            foreach ([5, 3] as $score) {
                Rating::create([
                    'rateable_type' => Teacher::class,
                    'rateable_id' => $teacher->id,
                    'author' => 'Seeder',
                    'score' => $score,
                    'note' => 'Teacher rating seed',
                ]);
            }
        }
    }
}
