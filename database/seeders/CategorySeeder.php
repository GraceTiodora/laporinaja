<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Jalan Rusak', 'slug' => 'jalan-rusak', 'description' => 'Laporan tentang jalan yang berlubang atau rusak'],
            ['name' => 'Sampah Menumpuk', 'slug' => 'sampah-menumpuk', 'description' => 'Area sampah menumpuk dan kotor'],
            ['name' => 'Lampu Jalan Mati', 'slug' => 'lampu-jalan-mati', 'description' => 'Lampu jalan yang tidak menyala'],
            ['name' => 'Air Macet', 'slug' => 'air-macet', 'description' => 'Saluran air atau drainase yang macet'],
            ['name' => 'Pohon Tumbang', 'slug' => 'pohon-tumbang', 'description' => 'Pohon yang tumbang dan mengganggu aktivitas'],
            ['name' => 'Keamanan', 'slug' => 'keamanan', 'description' => 'Masalah keamanan dan kriminalitas'],
            ['name' => 'Infrastruktur', 'slug' => 'infrastruktur', 'description' => 'Masalah infrastruktur umum'],
            ['name' => 'Kebersihan', 'slug' => 'kebersihan', 'description' => 'Masalah kebersihan lingkungan'],
            ['name' => 'Utilitas Publik', 'slug' => 'utilitas-publik', 'description' => 'Masalah air, listrik, atau gas'],
            ['name' => 'Lalu Lintas', 'slug' => 'lalu-lintas', 'description' => 'Masalah lalu lintas dan transportasi'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'description' => $category['description']
                ]
            );
        }
    }
}
