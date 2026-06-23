<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rt;

class RtSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 6; $i++) {
            Rt::create([
                'nama_rt' => 'RT 0'.$i
            ]);
        }
    }
}