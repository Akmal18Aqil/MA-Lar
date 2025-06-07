<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'name' => 'Dosen User',
            'email' => 'dosen@example.com',
            'password' => bcrypt('password'),
            'role' => 'dosen',
        ]);

        \App\Models\User::create([
            'name' => 'Mahasantri User',
            'email' => 'mahasantri@example.com',
            'password' => bcrypt('password'),
            'role' => 'mahasantri',
        ]);
    }
}
