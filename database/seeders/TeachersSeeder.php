<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;

class TeachersSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            ['name' => 'Monther Ibrahim', 'subject' => 'Mathematics', 'experience' => 8],
            ['name' => 'Khadija Al-Mabrouk', 'subject' => 'Arabic Language', 'experience' => 12],
            ['name' => 'Noura Al-Gaddafi', 'subject' => 'Science', 'experience' => 5],
            ['name' => 'Zainab Al-Warfali', 'subject' => 'English Language', 'experience' => 7],
            ['name' => 'Hanan Al-Zawi', 'subject' => 'Islamic Education', 'experience' => 10],
        ];

        foreach ($teachers as $data) {
            Teacher::create($data);
        }
    }
}
