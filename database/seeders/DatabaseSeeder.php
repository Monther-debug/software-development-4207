<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminsSeeder::class,
            GradesSeeder::class,
            FeesSeeder::class,
            CommentsSeeder::class,
            RatingsSeeder::class,
            SchoolTeacherSeeder::class,
            SuccessRatingSeeder::class,
        ]);
    }
}
