<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\User;
use App\Models\Rating;

class RatingsSeeder extends Seeder
{
    public function run(): void
    {
        $school = School::first();
        $user = User::first();

        if ($school && $user) {
            foreach (['5', '4', '3'] as $ratingValue) {
                Rating::create([
                    'schoolID' => $school->id,
                    'userID' => $user->id,
                    'rating' => $ratingValue,
                ]);
            }
        }
    }
}
