<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\User;
use App\Models\Comment;

class CommentsSeeder extends Seeder
{
    public function run(): void
    {
        $school = School::first();
        $user = User::first();

        if ($school && $user) {
            Comment::firstOrCreate([
                'schoolID' => $school->id,
                'userID' => $user->id,
            ], [
                'comment' => 'Great school!',
            ]);
        }
    }
}
