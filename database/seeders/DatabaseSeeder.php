<?php

namespace Database\Seeders;

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
        // Buat Admin default
        User::create([
            'nama' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@simardas.test',
            'password' => Hash::make('password'),
            'role' => 'Admin'
        ]);

        // Buat Admin Fahmi
        User::create([
            'nama' => 'fahmi',
            'username' => 'fahmi',
            'email' => 'fahmi@gmail.com',
            'password' => Hash::make('chaewon'),
            'role' => 'Admin'
        ]);

        // Buat Petugas Arsip default
        User::create([
            'nama' => 'Petugas Arsip',
            'username' => 'petugas',
            'email' => 'petugas@simardas.test',
            'password' => Hash::make('password'),
            'role' => 'Petugas Arsip'
        ]);
    }
}
