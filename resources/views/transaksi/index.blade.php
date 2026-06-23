<x-app-layout>
    @section('page_title', 'Transaksi Kas')

    <!-- Success Alert -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center shadow-sm">
            <svg class="h-5 w-5 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-semibold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Card Container -->
    <div class="bg-white rounded-2xl shadow-sm border border-[#E5E7EB] overflow-hidden">
        <!-- Header Section -->
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-gray-900">Riwayat Keuangan Kas RT</h3>
                <p class="text-xs text-gray-500">Catatan masuk dan keluar kas milik RT.</p>
            </div>

            @if(auth()->user()->role === 'admin')
                <div>
                    <a href="{{ route('transaksi.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-[#2F5D34] hover:bg-[#4F7A3F] active:bg-[#2F5D34] text-white text-xs font-bold rounded-xl transition-all shadow-sm hover:-translate-y-0.5">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Transaksi
                    </a>
                </div>
            @endif
        </div>

        <!-- Responsive Table Container -->
        <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
            <table class="min-w-full text-left border-collapse">
                <!-- Sticky Header with Primary Green Background -->
                <thead class="sticky top-0 bg-[#2F5D34] text-white z-10">
                    <tr>
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider">Jenis</th>
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider">Keterangan</th>
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider">Nominal</th>
                        @if(auth()->user()->role === 'admin')
                            <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <!-- Zebra Striped Table Body -->
                <tbody class="divide-y divide-gray-100">
                    @forelse($transaksis as $transaksi)
                        <tr class="odd:bg-white even:bg-[#F8FAF5] hover:bg-[#EAF3E6]/40 transition-colors">
                            <td class="px-6 py-4 text-xs whitespace-nowrap text-gray-600 font-medium">
                                {{ \Carbon\Carbon::parse($transaksi->tanggal)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs">
                                @if($transaksi->jenis === 'masuk')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        Kas Masuk
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800 border border-rose-200">
                                        Kas Keluar
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-800 font-semibold">
                                {{ $transaksi->keterangan }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-gray-900">
                                Rp {{ number_format($transaksi->nominal, 0, ',', '.') }}
                            </td>
                            @if(auth()->user()->role === 'admin')
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <!-- Consistent color button triggers -->
                                        <a href="{{ route('transaksi.edit', $transaksi->id) }}"
                                           class="inline-flex items-center px-2.5 py-1 bg-amber-50 hover:bg-amber-100 text-amber-700 text-[10px] font-bold rounded-lg border border-amber-200 transition-colors">
                                            Edit
                                        </a>
                                        <form action="{{ route('transaksi.destroy', $transaksi->id) }}"
                                              method="POST"
                                              class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')"
                                                    class="inline-flex items-center px-2.5 py-1 bg-rose-50 hover:bg-rose-100 text-rose-700 text-[10px] font-bold rounded-lg border border-rose-200 transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role === 'admin' ? 5 : 4 }}" class="px-6 py-12 text-center text-xs text-gray-500">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Belum ada data transaksi keuangan di RT ini.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>