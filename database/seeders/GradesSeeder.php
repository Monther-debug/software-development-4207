<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grade;

class GradesSeeder extends Seeder
{
    public function run(): void
    {
        $grades = [
            ['name' => 'Grade 1'],
            ['name' => 'Grade 2'],
            ['name' => 'Grade 3'],
            ['name' => 'Grade 4'],
            ['name' => 'Grade 5'],
            ['name' => 'Grade 6'],
            ['name' => 'Grade 7'],
            ['name' => 'Grade 8'],
            ['name' => 'Grade 9'],
            ['name' => 'Grade 10'],
            ['name' => 'Grade 11'],
            ['name' => 'Grade 12'],
        ];

        foreach ($grades as $data) {
            Grade::firstOrCreate(['name' => $data['name']], $data);
        }
    }
}
