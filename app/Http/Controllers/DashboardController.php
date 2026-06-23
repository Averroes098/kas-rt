<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Inventaris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user()->load('rt');
        $rtId = $user->rt_id;
        $namaRt = $user->rt ? $user->rt->nama_rt : 'RT -';

        // Hitung total pemasukan
        $totalMasuk = Transaksi::where('rt_id', $rtId)
            ->where('jenis', 'masuk')
            ->sum('nominal');

        // Hitung total pengeluaran
        $totalKeluar = Transaksi::where('rt_id', $rtId)
            ->where('jenis', 'keluar')
            ->sum('nominal');

        // Hitung saldo akhir
        $saldo = $totalMasuk - $totalKeluar;

        // Hitung jumlah transaksi
        $jumlahTransaksi = Transaksi::where('rt_id', $rtId)
            ->count();

        // Hitung jumlah jenis barang inventaris
        $jumlahInventaris = Inventaris::where('rt_id', $rtId)
            ->count();

        // Hitung total kuantitas seluruh barang inventaris
        $totalBarangInventaris = Inventaris::where('rt_id', $rtId)
            ->sum('jumlah');

        // ======== ANALYTICS V6 ========

        // Parameter periode (3, 6, atau 12 bulan — default 6)
        $periode = intval($request->query('periode', 6));
        if (!in_array($periode, [3, 6, 12])) {
            $periode = 6;
        }

        $driver = DB::connection()->getDriverName();
        $dateFormat = $driver === 'sqlite' ? 'strftime("%Y-%m", tanggal)' : 'DATE_FORMAT(tanggal, "%Y-%m")';

        // Deteksi minimum bulan yang memiliki data
        $jumlahBulanData = Transaksi::where('rt_id', $rtId)
            ->selectRaw("DISTINCT {$dateFormat} as bulan")
            ->count(DB::raw("DISTINCT {$dateFormat}"));

        // Get the latest transaction date for reference
        $latestTransactionDate = Transaksi::where('rt_id', $rtId)->max('tanggal');
        $referenceDate = $latestTransactionDate ? Carbon::parse($latestTransactionDate) : Carbon::now();

        // Hitung surplus bulan ini & bulan lalu menggunakan $referenceDate
        $bulanIni = $referenceDate->copy()->startOfMonth();
        $bulanLalu = $referenceDate->copy()->subMonth()->startOfMonth();

        $totalMasukBulanIni = Transaksi::where('rt_id', $rtId)
            ->where('jenis', 'masuk')
            ->whereBetween('tanggal', [$bulanIni, $referenceDate])
            ->sum('nominal');

        $totalKeluarBulanIni = Transaksi::where('rt_id', $rtId)
            ->where('jenis', 'keluar')
            ->whereBetween('tanggal', [$bulanIni, $referenceDate])
            ->sum('nominal');

        $totalMasukBulanLalu = Transaksi::where('rt_id', $rtId)
            ->where('jenis', 'masuk')
            ->whereBetween('tanggal', [$bulanLalu, $bulanIni->copy()->subDay()])
            ->sum('nominal');

        $totalKeluarBulanLalu = Transaksi::where('rt_id', $rtId)
            ->where('jenis', 'keluar')
            ->whereBetween('tanggal', [$bulanLalu, $bulanIni->copy()->subDay()])
            ->sum('nominal');

        $surplusBulanIni = $totalMasukBulanIni - $totalKeluarBulanIni;
        $surplusBulanLalu = $totalMasukBulanLalu - $totalKeluarBulanLalu;

        // Growth percentage — null jika data < 2 bulan atau pembagi <= 0
        if ($jumlahBulanData < 2 || $surplusBulanLalu <= 0) {
            $surplusGrowth = null;
        } else {
            $surplusGrowth = round((($surplusBulanIni - $surplusBulanLalu) / $surplusBulanLalu) * 100, 1);
        }

        // Growth pemasukan
        if ($jumlahBulanData < 2 || $totalMasukBulanLalu <= 0) {
            $pemasukanGrowth = null;
        } else {
            $pemasukanGrowth = round((($totalMasukBulanIni - $totalMasukBulanLalu) / $totalMasukBulanLalu) * 100, 1);
        }

        // Growth pengeluaran
        if ($jumlahBulanData < 2 || $totalKeluarBulanLalu <= 0) {
            $pengeluaranGrowth = null;
        } else {
            $pengeluaranGrowth = round((($totalKeluarBulanIni - $totalKeluarBulanLalu) / $totalKeluarBulanLalu) * 100, 1);
        }

        // ======== CHART DATA ========

        // Hitung saldo awal sebelum window periode menggunakan $referenceDate
        $startDate = $referenceDate->copy()->subMonths($periode - 1)->startOfMonth();

        $saldoAwal = Transaksi::where('rt_id', $rtId)
            ->where('tanggal', '<', $startDate)
            ->selectRaw("SUM(CASE WHEN jenis = 'masuk' THEN nominal ELSE 0 END) - SUM(CASE WHEN jenis = 'keluar' THEN nominal ELSE 0 END) as saldo")
            ->value('saldo') ?? 0;

        // Aggregate per bulan dalam window (dibatasi sampai end of month dari $referenceDate)
        $monthlyData = Transaksi::where('rt_id', $rtId)
            ->whereBetween('tanggal', [$startDate, $referenceDate->copy()->endOfMonth()])
            ->selectRaw("{$dateFormat} as bulan")
            ->selectRaw("SUM(CASE WHEN jenis = 'masuk' THEN nominal ELSE 0 END) as total_masuk")
            ->selectRaw("SUM(CASE WHEN jenis = 'keluar' THEN nominal ELSE 0 END) as total_keluar")
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->keyBy('bulan');

        // Generate complete month labels
        $chartLabels = [];
        $chartPemasukan = [];
        $chartPengeluaran = [];
        $chartSaldo = [];
        $runningBalance = $saldoAwal;

        // Peak values
        $peakPemasukan = 0;
        $peakPemasukanBulan = '-';
        $peakPengeluaran = 0;
        $peakPengeluaranBulan = '-';

        for ($i = 0; $i < $periode; $i++) {
            $monthKey = $startDate->copy()->addMonths($i)->format('Y-m');
            $monthLabel = Carbon::createFromFormat('Y-m', $monthKey)->translatedFormat('M Y');

            $masuk = $monthlyData->has($monthKey) ? $monthlyData[$monthKey]->total_masuk : 0;
            $keluar = $monthlyData->has($monthKey) ? $monthlyData[$monthKey]->total_keluar : 0;

            $runningBalance += ($masuk - $keluar);

            $chartLabels[] = $monthLabel;
            $chartPemasukan[] = $masuk;
            $chartPengeluaran[] = $keluar;
            $chartSaldo[] = $runningBalance;

            if ($masuk > $peakPemasukan) {
                $peakPemasukan = $masuk;
                $peakPemasukanBulan = $monthLabel;
            }
            if ($keluar > $peakPengeluaran) {
                $peakPengeluaran = $keluar;
                $peakPengeluaranBulan = $monthLabel;
            }
        }

        return view('dashboard', compact(
            'saldo',
            'totalMasuk',
            'totalKeluar',
            'jumlahTransaksi',
            'jumlahInventaris',
            'totalBarangInventaris',
            'namaRt',
            'periode',
            'jumlahBulanData',
            'surplusGrowth',
            'pemasukanGrowth',
            'pengeluaranGrowth',
            'chartLabels',
            'chartPemasukan',
            'chartPengeluaran',
            'chartSaldo',
            'peakPemasukan',
            'peakPemasukanBulan',
            'peakPengeluaran',
            'peakPengeluaranBulan'
        ));
    }
}