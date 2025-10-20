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
            'name' => 'Demo School',
            'address' => '123 Main St',
            'status' => 'active',
            'type' => 'public',
            'level' => 'primary',
        ]);

        // Ensure at least one grade exists for the school
        $grade = Grade::where('school_id', $school->id)->first() ?? Grade::create([
            'school_id' => $school->id,
            'name' => 'Grade 1',
            'code' => 'G1',
            'status' => 'active',
        ]);

        // Seed a few fees
        $fees = [
            [
                'school_id' => $school->id,
                'grade_id' => $grade->id,
                'name' => 'Tuition',
                'code' => 'TUITION',
                'amount' => 500.00,
                'currency' => 'USD',
                'frequency' => 'term',
                'status' => 'active',
                'due_date' => now()->addDays(30)->toDateString(),
                'description' => 'Term tuition fee',
            ],
            [
                'school_id' => $school->id,
                'grade_id' => null,
                'name' => 'Registration',
                'code' => 'REG',
                'amount' => 50.00,
                'currency' => 'USD',
                'frequency' => 'once',
                'status' => 'active',
                'due_date' => now()->addDays(10)->toDateString(),
                'description' => 'One-time registration fee',
            ],
        ];

        foreach ($fees as $data) {
            Fee::firstOrCreate([
                'school_id' => $data['school_id'],
                'code' => $data['code'],
            ], $data);
        }
    }
}
