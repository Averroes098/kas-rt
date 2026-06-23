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
            // Seed Admin per RT
            User::updateOrCreate(
                ['email' => 'admin' . $i . '@gmail.com'],
                [
                    'name'     => 'Admin RT 0' . $i,
                    'password' => Hash::make('admin12345'),
                    'role'     => 'admin',
                    'rt_id'    => $i,
                ]
            );

            // Seed Warga per RT
            User::updateOrCreate(
                ['email' => 'warga' . $i . '@gmail.com'],
                [
                    'name'     => 'Warga RT 0' . $i,
                    'password' => Hash::make('admin12345'),
                    'role'     => 'warga',
                    'rt_id'    => $i,
                ]
            );
        }
    }
}