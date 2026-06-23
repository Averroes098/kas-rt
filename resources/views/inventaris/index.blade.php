<x-app-layout>
    @section('page_title', 'Inventaris RT')

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
                <h3 class="text-base font-bold text-gray-900">Daftar Barang Inventaris RT</h3>
                <p class="text-xs text-gray-500">Pencatatan sarana dan prasarana milik RT.</p>
            </div>

            @if(auth()->user()->role === 'admin')
                <div>
                    <a href="{{ route('inventaris.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-[#2F5D34] hover:bg-[#4F7A3F] active:bg-[#2F5D34] text-white text-xs font-bold rounded-xl transition-all shadow-sm hover:-translate-y-0.5">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Barang
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
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider">Nama Barang</th>
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider">Kondisi</th>
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider">Lokasi</th>
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider">Tahun Perolehan</th>
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider">Keterangan</th>
                        @if(auth()->user()->role === 'admin')
                            <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <!-- Zebra Striped Table Body -->
                <tbody class="divide-y divide-gray-100">
                    @forelse($inventarisList as $item)
                        <tr class="odd:bg-white even:bg-[#F8FAF5] hover:bg-[#EAF3E6]/40 transition-colors">
                            <td class="px-6 py-4 text-xs text-gray-900 font-bold">
                                {{ $item->nama_barang }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-800 font-semibold">
                                {{ $item->jumlah }} unit
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs">
                                @if($item->kondisi === 'Baik')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        Baik
                                    </span>
                                @elseif($item->kondisi === 'Rusak Ringan')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                        Rusak Ringan
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800 border border-rose-200">
                                        Rusak Berat
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-700 font-medium">
                                {{ $item->lokasi }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 font-medium">
                                {{ $item->tahun_perolehan }}
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500 max-w-xs truncate">
                                {{ $item->keterangan ?? '-' }}
                            </td>
                            @if(auth()->user()->role === 'admin')
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('inventaris.edit', $item->id) }}"
                                           class="inline-flex items-center px-2.5 py-1 bg-amber-50 hover:bg-amber-100 text-amber-700 text-[10px] font-bold rounded-lg border border-amber-200 transition-colors">
                                            Edit
                                        </a>
                                        <form action="{{ route('inventaris.destroy', $item->id) }}"
                                              method="POST"
                                              class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')"
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
                            <td colspan="{{ auth()->user()->role === 'admin' ? 7 : 6 }}" class="px-6 py-12 text-center text-xs text-gray-500">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    <span>Belum ada data barang inventaris di RT ini.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
