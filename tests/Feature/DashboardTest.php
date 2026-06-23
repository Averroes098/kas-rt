<?php

use App\Models\User;
use App\Models\Rt;
use App\Models\Transaksi;
use Carbon\Carbon;

test('dashboard displays correct statistics and chart data based on reference date', function () {
    // 1. Setup RT and Admin User
    $rt = Rt::create(['nama_rt' => 'RT 01 Bintaran']);
    $user = User::create([
        'name' => 'Admin RT 01',
        'email' => 'admin.rt01@example.com',
        'password' => bcrypt('password'),
        'role' => 'admin',
        'rt_id' => $rt->id,
    ]);

    // 2. Setup Historical Transactions
    // 22 Mar 2026 — Kas Masuk — Rp 2.000.000
    Transaksi::create([
        'rt_id' => $rt->id,
        'tanggal' => '2026-03-22',
        'jenis' => 'masuk',
        'keterangan' => 'Kas Masuk Maret',
        'nominal' => 2000000.00,
    ]);

    // 17 Jun 2026 — Kas Masuk — Rp 2.500.000
    Transaksi::create([
        'rt_id' => $rt->id,
        'tanggal' => '2026-06-17',
        'jenis' => 'masuk',
        'keterangan' => 'Kas Masuk Juni A',
        'nominal' => 2500000.00,
    ]);

    // 19 Jun 2026 — Kas Masuk — Rp 750.000
    Transaksi::create([
        'rt_id' => $rt->id,
        'tanggal' => '2026-06-19',
        'jenis' => 'masuk',
        'keterangan' => 'Kas Masuk Juni B',
        'nominal' => 750000.00,
    ]);

    // 25 Jun 2026 — Kas Keluar — Rp 2.000.000
    Transaksi::create([
        'rt_id' => $rt->id,
        'tanggal' => '2026-06-25',
        'jenis' => 'keluar',
        'keterangan' => 'Kas Keluar Juni A',
        'nominal' => 2000000.00,
    ]);

    // 20 Jun 2026 — Kas Keluar — Rp 450.000
    Transaksi::create([
        'rt_id' => $rt->id,
        'tanggal' => '2026-06-20',
        'jenis' => 'keluar',
        'keterangan' => 'Kas Keluar Juni B',
        'nominal' => 450000.00,
    ]);

    // 21 Jun 2026 — Kas Keluar — Rp 180.000
    Transaksi::create([
        'rt_id' => $rt->id,
        'tanggal' => '2026-06-21',
        'jenis' => 'keluar',
        'keterangan' => 'Kas Keluar Juni C',
        'nominal' => 180000.00,
    ]);

    // 3. Act & Assert
    $response = $this->actingAs($user)
        ->get('/dashboard?periode=6');

    $response->assertStatus(200);

    // Verify view variables returned to the view
    $response->assertViewHas('saldo', 2620000.00);
    $response->assertViewHas('totalMasuk', 5250000.00);
    $response->assertViewHas('totalKeluar', 2630000.00);

    $response->assertViewHas('peakPemasukan', 3250000.00); // June 2026 total masuk
    $response->assertViewHas('peakPengeluaran', 2630000.00); // June 2026 total keluar

    $chartLabels = $response->viewData('chartLabels');
    $chartPemasukan = $response->viewData('chartPemasukan');
    $chartPengeluaran = $response->viewData('chartPengeluaran');
    $chartSaldo = $response->viewData('chartSaldo');

    // 6-month period should include: Jan 2026, Feb 2026, Mar 2026, Apr 2026, Mei 2026, Jun 2026
    expect($chartLabels)->toHaveCount(6);
    expect(strtolower($chartLabels[5]))->toContain('jun');

    // Match June data:
    expect($chartPemasukan[5])->toEqual(3250000.00);
    expect($chartPengeluaran[5])->toEqual(2630000.00);
    expect($chartSaldo[5])->toEqual(2620000.00);

    // Match March data:
    expect($chartPemasukan[2])->toEqual(2000000.00);
    expect($chartPengeluaran[2])->toEqual(0.00);
    expect($chartSaldo[2])->toEqual(2000000.00);
});
