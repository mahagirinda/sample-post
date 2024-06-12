<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
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
    }
}
