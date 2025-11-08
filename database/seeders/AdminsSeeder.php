<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\Manager;
use App\Models\Admin;

class AdminsSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure there is at least one school
        $school = School::first() ?? School::create([
            'name' => 'Seed School',
            'address' => '100 Seed Ave',
            'status' => 'active',
            'type' => 'female',
            'level' => 'secondary',
        ]);

        $manager = Manager::first() ?? Manager::create([
            'name' => 'Seed Manager',
            'username' => 'seedmanager',
            'phone_number' => '1234567890',
            'password' => 'password',
            'schoolID' => $school->id,
        ]);

        $admins = [
            [
                'name' => 'Main Admin',
                'email' => 'admin@example.com',
                'phone_number' => '0987654321',
                'password' => 'password',
            ],
            [
                'name' => 'Support Admin',
                'email' => 'support.admin@example.com',
                'phone_number' => '0987654322',
                'password' => 'password',
            ],
        ];

        foreach ($admins as $data) {
            Admin::firstOrCreate([
                'email' => $data['email'],
            ], $data);
        }
    }
}
