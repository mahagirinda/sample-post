<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /**
         * Initial Category Data Seed
         */
        $categories = [
            [
                'name' => 'Kuliner',
                'detail' => 'Kategori tentang makanan dan minuman',
                'status' => true,
            ],
            [
                'name' => 'Binatang',
                'detail' => 'Kategori tentang hewan dan fauna',
                'status' => true,
            ],
            [
                'name' => 'Gaya Hidup',
                'detail' => 'Kategori tentang gaya hidup dan tren',
                'status' => true,
            ],
            [
                'name' => 'Entertainment',
                'detail' => 'Kategori tentang hiburan dan seni',
                'status' => true,
            ],
            [
                'name' => 'Education',
                'detail' => 'Kategori tentang edukasi dan pendidikan',
                'status' => true,
            ],
            [
                'name' => 'Art',
                'detail' => 'Kategori tentang karya seni',
                'status' => true,
            ],
            [
                'name' => 'Tips & Trick',
                'detail' => 'Kategori tentang tips dan trik',
                'status' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        /**
         * Initial User Data Seed if not on production
         */
        if(!env('APP_ENV') == 'production') {
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
}
