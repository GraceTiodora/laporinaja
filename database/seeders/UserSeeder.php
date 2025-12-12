<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Seprian Siagian',
            'email' => 'seprian@test.com',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@test.com',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => 'Ani Wijaya',
            'email' => 'ani@test.com',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => 'Rini Kusuma',
            'email' => 'rini@test.com',
            'password' => bcrypt('password'),
        ]);
    }
}
