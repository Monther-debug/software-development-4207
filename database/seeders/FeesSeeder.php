<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\Grade;
use App\Models\Fee;

class FeesSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure at least one school exists
        $school = School::first() ?? School::create([
            'name' => 'Al-Andalus Secondary School',
            'address' => 'Omar Al-Mukhtar Street, Benghazi',
            'status' => 'active',
            'type' => 'male',
            'level' => 'secondary',
        ]);

        // Get some grades
        $grade1 = Grade::where('name', 'Grade 1')->first();
        $grade2 = Grade::where('name', 'Grade 2')->first();
        $grade3 = Grade::where('name', 'Grade 3')->first();

        if ($grade1 && $grade2 && $grade3) {
            // Seed fees
            $fees = [
                ['schoolID' => $school->id, 'gradeID' => $grade1->id, 'amount' => 350.00],
                ['schoolID' => $school->id, 'gradeID' => $grade2->id, 'amount' => 400.00],
                ['schoolID' => $school->id, 'gradeID' => $grade3->id, 'amount' => 450.00],
            ];

            foreach ($fees as $data) {
                Fee::create($data);
            }
        }
    }
}
