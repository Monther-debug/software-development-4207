<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Test User', 'email' => 'user@example.com', 'password' => 'password'],
            ['name' => 'Demo User', 'email' => 'demo@example.com', 'password' => 'password'],
        ];

        foreach ($users as $data) {
            User::firstOrCreate(['email' => $data['email']], $data);
        }
    }
}
