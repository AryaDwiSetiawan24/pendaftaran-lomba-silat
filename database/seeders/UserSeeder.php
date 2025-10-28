<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Lomba',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'status' => 'active',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => 'Arya',
            'email' => 'peserta@example.com',
            'role' => 'peserta',
            'status' => 'active',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => 'Setya',
            'email' => 'peserta1@example.com',
            'role' => 'peserta',
            'status' => 'active',
            'password' => bcrypt('password'),
        ]);
    }
}
