<x-app-layout>
    @section('page_title', 'Dashboard')

    <!-- Welcome Card (~100px height lock) -->
    <div class="mb-6 bg-white border border-[#E5E7EB] rounded-2xl p-6 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between min-h-[90px] gap-4">
        <div>
            <h2 class="text-base md:text-lg font-bold text-gray-900 leading-tight">
                Selamat Datang, <span class="text-[#2F5D34] font-black">{{ auth()->user()->name }}</span>
            </h2>
            <p class="text-xs text-gray-500 mt-0.5">
                RT Aktif: <span class="font-bold text-gray-800">{{ auth()->user()->rt ? auth()->user()->rt->nama_rt : '-' }}</span>
            </p>
        </div>
        <div class="text-left md:text-right">
            <span class="text-[10px] font-bold text-gray-400 block uppercase tracking-wider">Tanggal</span>
            <span class="text-xs md:text-sm font-bold text-gray-700 mt-0.5 block">
                {{ now()->translatedFormat('d F Y') }}
            </span>
        </div>
    </div>

    <!-- Section Title: Keuangan -->
    <div class="mb-3 flex items-center justify-between">
        <h3 class="text-[10px] font-black uppercase tracking-wider text-gray-400 flex items-center">
            <span class="w-2 h-2 bg-[#2F5D34] rounded-full mr-2"></span>
            Ringkasan Keuangan Kas
        </h3>
    </div>

    <!-- Grid Baris 1: Keuangan (4 Columns) -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <!-- Saldo Saat Ini -->
        <div class="bg-white custom-card-stat rounded-2xl border border-[#E5E7EB] p-5 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between relative overflow-hidden">
            <div class="flex justify-between items-start">
                <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Saldo Saat Ini</span>
                <span class="p-2 rounded-xl bg-[#EAF3E6] text-[#2F5D34]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <div class="mt-2">
                <h4 class="text-base md:text-lg font-black text-gray-900 tracking-tight">
                    Rp {{ number_format($saldo, 0, ',', '.') }}
                </h4>
                <!-- Growth Indicator -->
                @if($surplusGrowth === null)
                    <p class="text-[9px] text-gray-400 mt-1">Data pembanding belum mencukupi</p>
                @elseif($surplusGrowth > 0)
                    <p class="text-[9px] text-emerald-600 font-semibold mt-1">▲ {{ $surplusGrowth }}% surplus dibanding bulan lalu</p>
                @elseif($surplusGrowth < 0)
                    <p class="text-[9px] text-rose-600 font-semibold mt-1">▼ {{ abs($surplusGrowth) }}% surplus dibanding bulan lalu</p>
                @else
                    <p class="text-[9px] text-gray-500 font-semibold mt-1">— Surplus sama dengan bulan lalu</p>
                @endif
            </div>
        </div>

        <!-- Total Pemasukan -->
        <div class="bg-white custom-card-stat rounded-2xl border border-[#E5E7EB] p-5 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between relative overflow-hidden">
            <div class="flex justify-between items-start">
                <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Total Pemasukan</span>
                <span class="p-2 rounded-xl bg-emerald-50 text-emerald-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <div class="mt-2">
                <h4 class="text-base md:text-lg font-black text-emerald-700 tracking-tight">
                    Rp {{ number_format($totalMasuk, 0, ',', '.') }}
                </h4>
                @if($pemasukanGrowth === null)
                    <p class="text-[9px] text-gray-400 mt-1">Data pembanding belum mencukupi</p>
                @elseif($pemasukanGrowth > 0)
                    <p class="text-[9px] text-emerald-600 font-semibold mt-1">▲ {{ $pemasukanGrowth }}% dibanding bulan lalu</p>
                @elseif($pemasukanGrowth < 0)
                    <p class="text-[9px] text-rose-600 font-semibold mt-1">▼ {{ abs($pemasukanGrowth) }}% dibanding bulan lalu</p>
                @else
                    <p class="text-[9px] text-gray-500 font-semibold mt-1">— Sama dengan bulan lalu</p>
                @endif
            </div>
        </div>

        <!-- Total Pengeluaran -->
        <div class="bg-white custom-card-stat rounded-2xl border border-[#E5E7EB] p-5 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between relative overflow-hidden">
            <div class="flex justify-between items-start">
                <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Total Pengeluaran</span>
                <span class="p-2 rounded-xl bg-rose-50 text-rose-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <div class="mt-2">
                <h4 class="text-base md:text-lg font-black text-rose-700 tracking-tight">
                    Rp {{ number_format($totalKeluar, 0, ',', '.') }}
                </h4>
                @if($pengeluaranGrowth === null)
                    <p class="text-[9px] text-gray-400 mt-1">Data pembanding belum mencukupi</p>
                @elseif($pengeluaranGrowth > 0)
                    <p class="text-[9px] text-rose-600 font-semibold mt-1">▲ {{ $pengeluaranGrowth }}% dibanding bulan lalu</p>
                @elseif($pengeluaranGrowth < 0)
                    <p class="text-[9px] text-emerald-600 font-semibold mt-1">▼ {{ abs($pengeluaranGrowth) }}% dibanding bulan lalu</p>
                @else
                    <p class="text-[9px] text-gray-500 font-semibold mt-1">— Sama dengan bulan lalu</p>
                @endif
            </div>
        </div>

        <!-- Jumlah Transaksi -->
        <div class="bg-white custom-card-stat rounded-2xl border border-[#E5E7EB] p-5 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between relative overflow-hidden">
            <div class="flex justify-between items-start">
                <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Jumlah Transaksi</span>
                <span class="p-2 rounded-xl bg-blue-50 text-blue-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2H9m1.414-1.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l3.414-3.414z" />
                    </svg>
                </span>
            </div>
            <div class="mt-2">
                <h4 class="text-base md:text-lg font-black text-gray-900 tracking-tight">
                    {{ $jumlahTransaksi }} Catatan
                </h4>
                <p class="text-[9px] text-gray-400 mt-1">Total riwayat</p>
            </div>
        </div>
    </div>

    <!-- Section Title: Inventaris -->
    <div class="mb-3 flex items-center justify-between">
        <h3 class="text-[10px] font-black uppercase tracking-wider text-gray-400 flex items-center">
            <span class="w-2 h-2 bg-[#2F5D34] rounded-full mr-2"></span>
            Ringkasan Inventaris Barang
        </h3>
    </div>

    <!-- Grid Baris 2: Inventaris (2 Columns) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Jenis Barang -->
        <div class="bg-white custom-card-stat rounded-2xl border border-[#E5E7EB] p-5 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between relative overflow-hidden">
            <div class="flex justify-between items-start">
                <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Jenis Barang</span>
                <span class="p-2 rounded-xl bg-purple-50 text-purple-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </span>
            </div>
            <div class="mt-2">
                <h4 class="text-base md:text-lg font-black text-gray-900 tracking-tight">
                    {{ $jumlahInventaris }} Kategori Aset
                </h4>
                <p class="text-[9px] text-gray-400 mt-1">Variasi jenis barang</p>
            </div>
        </div>

        <!-- Total Kuantitas -->
        <div class="bg-white custom-card-stat rounded-2xl border border-[#E5E7EB] p-5 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between relative overflow-hidden">
            <div class="flex justify-between items-start">
                <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Total Barang</span>
                <span class="p-2 rounded-xl bg-amber-50 text-amber-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </span>
            </div>
            <div class="mt-2">
                <h4 class="text-base md:text-lg font-black text-gray-900 tracking-tight">
                    {{ $totalBarangInventaris }} Unit
                </h4>
                <p class="text-[9px] text-gray-400 mt-1">Total fisik unit terdaftar</p>
            </div>
        </div>
    </div>

    <!-- ======== TREN KEUANGAN RT (Analytics V6) ======== -->
    <div class="mb-3 flex items-center justify-between">
        <h3 class="text-[10px] font-black uppercase tracking-wider text-gray-400 flex items-center">
            <span class="w-2 h-2 bg-[#D4A62A] rounded-full mr-2"></span>
            Tren Keuangan RT
        </h3>
        <!-- Dropdown Periode -->
        <div>
            <select id="periodeSelect" onchange="window.location.href='?periode='+this.value"
                class="text-xs font-semibold border border-[#E5E7EB] rounded-xl px-3 py-1.5 bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#2F5D34]/20 focus:border-[#2F5D34] cursor-pointer">
                <option value="3" {{ $periode == 3 ? 'selected' : '' }}>3 Bulan</option>
                <option value="6" {{ $periode == 6 ? 'selected' : '' }}>6 Bulan</option>
                <option value="12" {{ $periode == 12 ? 'selected' : '' }}>12 Bulan</option>
            </select>
        </div>
    </div>

    <!-- Peak Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div class="bg-white rounded-xl border border-[#E5E7EB] p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="p-2 rounded-lg bg-emerald-50 text-emerald-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </span>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Pemasukan Tertinggi</p>
                    <p class="text-sm font-black text-emerald-700">Rp {{ number_format($peakPemasukan, 0, ',', '.') }}</p>
                    <p class="text-[9px] text-gray-400">{{ $peakPemasukanBulan }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-[#E5E7EB] p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="p-2 rounded-lg bg-rose-50 text-rose-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"/>
                    </svg>
                </span>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Pengeluaran Tertinggi</p>
                    <p class="text-sm font-black text-rose-700">Rp {{ number_format($peakPengeluaran, 0, ',', '.') }}</p>
                    <p class="text-[9px] text-gray-400">{{ $peakPengeluaranBulan }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Container -->
    <div class="bg-white rounded-2xl border border-[#E5E7EB] p-6 shadow-sm mb-4">
        @if($jumlahTransaksi > 0)
            <canvas id="trendChart" style="width:100%; max-height:350px;"></canvas>
        @else
            <div class="flex flex-col items-center justify-center py-12 text-gray-400">
                <span class="text-4xl mb-3">📊</span>
                <p class="text-sm font-semibold">Belum ada data transaksi</p>
                <p class="text-xs">untuk ditampilkan pada grafik.</p>
            </div>
        @endif
    </div>

    @if($jumlahTransaksi > 0)
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('trendChart').getContext('2d');

            const rupiahFormat = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [
                        {
                            label: 'Pemasukan',
                            data: {!! json_encode($chartPemasukan) !!},
                            borderColor: '#2F5D34',
                            backgroundColor: 'rgba(47, 93, 52, 0.08)',
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.35,
                            pointRadius: 4,
                            pointBackgroundColor: '#2F5D34',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointHoverRadius: 6,
                        },
                        {
                            label: 'Pengeluaran',
                            data: {!! json_encode($chartPengeluaran) !!},
                            borderColor: '#DC2626',
                            backgroundColor: 'rgba(220, 38, 38, 0.06)',
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.35,
                            pointRadius: 4,
                            pointBackgroundColor: '#DC2626',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointHoverRadius: 6,
                        },
                        {
                            label: 'Saldo Kas',
                            data: {!! json_encode($chartSaldo) !!},
                            borderColor: '#D4A62A',
                            backgroundColor: 'transparent',
                            borderWidth: 2.5,
                            borderDash: [6, 4],
                            fill: false,
                            tension: 0.35,
                            pointRadius: 4,
                            pointBackgroundColor: '#D4A62A',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointHoverRadius: 6,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'circle',
                                padding: 20,
                                font: { family: 'Inter', size: 12, weight: '600' },
                                color: '#6B7280',
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(31, 41, 55, 0.95)',
                            titleFont: { family: 'Inter', size: 13, weight: '700' },
                            bodyFont: { family: 'Inter', size: 12 },
                            padding: 12,
                            cornerRadius: 10,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + rupiahFormat.format(context.parsed.y);
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { family: 'Inter', size: 11, weight: '500' },
                                color: '#9CA3AF',
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(229, 231, 235, 0.5)' },
                            ticks: {
                                font: { family: 'Inter', size: 11, weight: '500' },
                                color: '#9CA3AF',
                                callback: function(value) {
                                    if (value >= 1000000) return (value / 1000000).toFixed(1) + ' Jt';
                                    if (value >= 1000) return (value / 1000).toFixed(0) + ' Rb';
                                    return value;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endif

</x-app-layout>