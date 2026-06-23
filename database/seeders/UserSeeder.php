<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 6; $i++) {
            // Seed Admin
            User::create([
                'name' => 'Admin RT 0' . $i,
                'email' => 'admin' . $i . '@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'rt_id' => $i,
            ]);

            // Seed Warga
            User::create([
                'name' => 'Warga RT 0' . $i,
                'email' => 'warga' . $i . '@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'warga',
                'rt_id' => $i,
            ]);
        }
    }
}