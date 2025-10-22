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
            GradesSeeder::class,
            FeesSeeder::class,
            AdminsSeeder::class,
            CommentsSeeder::class,
            RatingsSeeder::class,
        ]);
    }
}
