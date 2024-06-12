<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Data user
        $users = [
            [
                'role' => 'admin',
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'role' => 'user',
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
