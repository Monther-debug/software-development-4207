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
        // Ensure there is at least one school and manager
        $school = School::first() ?? School::create([
            'name' => 'Seed School',
            'address' => '100 Seed Ave',
            'status' => 'active',
            'type' => 'public',
            'level' => 'secondary',
        ]);

        $manager = Manager::first() ?? Manager::create([
            'name' => 'Seed Manager',
            'email' => 'manager@example.com',
            'password' => 'secret1234',
            'school_id' => $school->id,
        ]);

        $admins = [
            [
                'name' => 'Main Admin',
                'email' => 'admin@example.com',
                'password' => 'secret1234',
                'manager_id' => $manager->id,
            ],
            [
                'name' => 'Support Admin',
                'email' => 'support.admin@example.com',
                'password' => 'secret1234',
                'manager_id' => $manager->id,
            ],
        ];

        foreach ($admins as $data) {
            Admin::firstOrCreate([
                'email' => $data['email'],
            ], $data);
        }
    }
}
