<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;

class TeachersSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            ['name' => 'John Doe', 'subject' => 'Mathematics', 'experience' => 5],
            ['name' => 'Jane Smith', 'subject' => 'English', 'experience' => 8],
            ['name' => 'Ahmed Ali', 'subject' => 'Science', 'experience' => 3],
        ];

        foreach ($teachers as $data) {
            Teacher::create($data);
        }
    }
}
