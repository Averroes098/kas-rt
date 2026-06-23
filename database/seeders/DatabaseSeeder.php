<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Transaksi;
use App\Models\Inventaris;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Jalankan seeder bawaan untuk RT dan User
        $this->call([
            RtSeeder::class,
            UserSeeder::class,
        ]);

        // Buat data transaksi contoh untuk RT 01 sampai RT 06
        for ($rtId = 1; $rtId <= 6; $rtId++) {
            // Transaksi Masuk
            Transaksi::create([
                'rt_id' => $rtId,
                'tanggal' => date('Y-m-d', strtotime('-5 days')),
                'jenis' => 'masuk',
                'keterangan' => 'Iuran Warga Bulanan RT 0' . $rtId,
                'nominal' => 2500000.00,
            ]);

            Transaksi::create([
                'rt_id' => $rtId,
                'tanggal' => date('Y-m-d', strtotime('-3 days')),
                'jenis' => 'masuk',
                'keterangan' => 'Donasi Kegiatan Agustusan RT 0' . $rtId,
                'nominal' => 750000.00,
            ]);

            // Transaksi Keluar
            Transaksi::create([
                'rt_id' => $rtId,
                'tanggal' => date('Y-m-d', strtotime('-2 days')),
                'jenis' => 'keluar',
                'keterangan' => 'Iuran Kebersihan & Pengangkutan Sampah RT 0' . $rtId,
                'nominal' => 450000.00,
            ]);

            Transaksi::create([
                'rt_id' => $rtId,
                'tanggal' => date('Y-m-d', strtotime('-1 days')),
                'jenis' => 'keluar',
                'keterangan' => 'Beli Lampu Penerangan Jalan RT 0' . $rtId,
                'nominal' => 180000.00,
            ]);

            // Data Inventaris Contoh
            Inventaris::create([
                'rt_id' => $rtId,
                'nama_barang' => 'Tenda Besi 4x6',
                'jumlah' => 2,
                'kondisi' => 'Baik',
                'lokasi' => 'Gudang RT 0' . $rtId,
                'tahun_perolehan' => 2024,
                'keterangan' => 'Digunakan untuk hajatan warga',
            ]);

            Inventaris::create([
                'rt_id' => $rtId,
                'nama_barang' => 'Kursi Plastik Napolly',
                'jumlah' => 120,
                'kondisi' => 'Baik',
                'lokasi' => 'Gudang RT 0' . $rtId,
                'tahun_perolehan' => 2024,
                'keterangan' => 'Warna hijau tua',
            ]);

            Inventaris::create([
                'rt_id' => $rtId,
                'nama_barang' => 'Speaker Portable Wireless',
                'jumlah' => 1,
                'kondisi' => 'Rusak Ringan',
                'lokasi' => 'Rumah Ketua RT 0' . $rtId,
                'tahun_perolehan' => 2025,
                'keterangan' => 'Baterai agak drop, perlu dicolok listrik',
            ]);
        }
    }
}