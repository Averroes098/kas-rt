<x-app-layout>
    @section('page_title', 'Edit Barang Inventaris')

    <div class="max-w-[800px] mx-auto">
        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl shadow-sm">
                <div class="font-bold text-xs mb-2">Terjadi kesalahan input:</div>
                <ul class="list-disc list-inside text-[11px] space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Card (bg-white, border-radius 16px/rounded-2xl) -->
        <div class="bg-white rounded-[16px] shadow-sm border border-[#E5E7EB] overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-[#F8FAF5]/40">
                <h3 class="text-base font-bold text-gray-900">Form Edit Barang</h3>
                <p class="text-xs text-gray-500">Ubah formulir di bawah ini untuk memperbarui data barang inventaris.</p>
            </div>

            <form action="{{ route('inventaris.update', $inventaris->id) }}" method="POST" class="p-6 space-y-5">
                @csrf
                @method('PUT')

                <!-- Nama Barang -->
                <div>
                    <label for="nama_barang" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama_barang" value="{{ old('nama_barang', $inventaris->nama_barang) }}" placeholder="Contoh: Tenda RT, Kursi Plastik"
                           class="w-full text-xs rounded-xl border-[#E5E7EB] focus:border-[#2F5D34] focus:ring-[#2F5D34] shadow-sm" required>
                </div>

                <!-- Jumlah -->
                <div>
                    <label for="jumlah" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Jumlah (Unit/Pcs)</label>
                    <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah', $inventaris->jumlah) }}" placeholder="0" min="1"
                           class="w-full text-xs rounded-xl border-[#E5E7EB] focus:border-[#2F5D34] focus:ring-[#2F5D34] shadow-sm" required>
                </div>

                <!-- Kondisi -->
                <div>
                    <label for="kondisi" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Kondisi Barang</label>
                    <select name="kondisi" id="kondisi" 
                            class="w-full text-xs rounded-xl border-[#E5E7EB] focus:border-[#2F5D34] focus:ring-[#2F5D34] shadow-sm" required>
                        <option value="">-- Pilih Kondisi --</option>
                        <option value="Baik" {{ old('kondisi', $inventaris->kondisi) == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Rusak Ringan" {{ old('kondisi', $inventaris->kondisi) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="Rusak Berat" {{ old('kondisi', $inventaris->kondisi) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                </div>

                <!-- Lokasi -->
                <div>
                    <label for="lokasi" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Lokasi Penyimpanan</label>
                    <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi', $inventaris->lokasi) }}" placeholder="Contoh: Gudang RT, Rumah Pak RT"
                           class="w-full text-xs rounded-xl border-[#E5E7EB] focus:border-[#2F5D34] focus:ring-[#2F5D34] shadow-sm" required>
                </div>

                <!-- Tahun Perolehan -->
                <div>
                    <label for="tahun_perolehan" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Tahun Perolehan</label>
                    <input type="number" name="tahun_perolehan" id="tahun_perolehan" value="{{ old('tahun_perolehan', $inventaris->tahun_perolehan) }}" min="1900" max="{{ date('Y') }}"
                           class="w-full text-xs rounded-xl border-[#E5E7EB] focus:border-[#2F5D34] focus:ring-[#2F5D34] shadow-sm" required>
                </div>

                <!-- Keterangan -->
                <div>
                    <label for="keterangan" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Keterangan Tambahan (Opsional)</label>
                    <textarea name="keterangan" id="keterangan" placeholder="Keterangan tambahan mengenai barang..." rows="3"
                              class="w-full text-xs rounded-xl border-[#E5E7EB] focus:border-[#2F5D34] focus:ring-[#2F5D34] shadow-sm">{{ old('keterangan', $inventaris->keterangan) }}</textarea>
                </div>

                <!-- Submit & Cancel Button -->
                <div class="pt-4 border-t border-gray-100 flex items-center justify-end space-x-2">
                    <a href="{{ route('inventaris.index') }}" 
                       class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-5 py-2 bg-[#2F5D34] hover:bg-[#4F7A3F] text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-[#2F5D34]/15">
                        Update Barang
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
