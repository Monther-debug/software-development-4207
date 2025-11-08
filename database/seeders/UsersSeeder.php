<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Monther Ibrahim', 'email' => 'monther@student.ly', 'password' => 'password'],
            ['name' => 'Ahmed Ibrahim', 'email' => 'ahmed@student.ly', 'password' => 'password'],
            ['name' => 'Laila Mahmoud', 'email' => 'laila@student.ly', 'password' => 'password'],
        ];

        foreach ($users as $data) {
            User::firstOrCreate(['email' => $data['email']], $data);
        }
    }
}
