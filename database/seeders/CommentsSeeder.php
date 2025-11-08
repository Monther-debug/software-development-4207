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
            $comments = [
                'Excellent school with dedicated teachers and good facilities.',
                'My children really enjoy studying here. The environment is very supportive.',
                'Great academic programs and extracurricular activities.',
            ];

            foreach ($comments as $commentText) {
                Comment::create([
                    'schoolID' => $school->id,
                    'userID' => $user->id,
                    'comment' => $commentText,
                ]);
            }
        }
    }
}
