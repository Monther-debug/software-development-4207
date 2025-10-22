<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\Teacher;
use App\Models\Comment;

class CommentsSeeder extends Seeder
{
    public function run(): void
    {
        $school = School::first();
        $teacher = Teacher::first();

        if ($school) {
            Comment::firstOrCreate([
                'commentable_type' => School::class,
                'commentable_id' => $school->id,
                'body' => 'Great school!'
            ], [
                'author' => 'Seeder',
            ]);
        }

        if ($teacher) {
            Comment::firstOrCreate([
                'commentable_type' => Teacher::class,
                'commentable_id' => $teacher->id,
                'body' => 'Inspiring teacher.'
            ], [
                'author' => 'Seeder',
            ]);
        }
    }
}
