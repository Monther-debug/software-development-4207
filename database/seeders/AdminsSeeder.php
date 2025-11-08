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
            'name' => 'Al-Noor Primary School',
            'address' => 'Al-Jumhuriya Street, Tripoli',
            'status' => 'active',
            'type' => 'female',
            'level' => 'primary',
        ]);

        $manager = Manager::first() ?? Manager::create([
            'name' => 'Fatima Ahmed',
            'username' => 'fatima.ahmed',
            'phone_number' => '0916880431',
            'password' => 'password',
            'schoolID' => $school->id,
        ]);

        $admins = [
            [
                'name' => 'Monther Ibrahim',
                'email' => 'monther@school.ly',
                'phone_number' => '0916880430',
                'password' => 'password',
            ],
            [
                'name' => 'Ali ',
                'email' => 'ali@school.ly',
                'phone_number' => '0913519105',
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
