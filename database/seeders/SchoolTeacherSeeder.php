<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolTeacherSeeder extends Seeder
{
    public function run(): void
    {
        // Simple insert; assumes school id 1, teacher id 1, grade id 1 exist
        DB::table('schools_teachers')->insertOrIgnore([
            [
                'schoolID' => 1,
                'teacherID' => 1,
                'gradeID' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
