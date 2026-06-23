<x-app-layout>
    @section('page_title', 'Edit Transaksi Kas')

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
                <h3 class="text-base font-bold text-gray-900">Form Edit Transaksi</h3>
                <p class="text-xs text-gray-500">Ubah formulir di bawah ini untuk memperbarui catatan kas.</p>
            </div>

            <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST" class="p-6 space-y-5">
                @csrf
                @method('PUT')

                <!-- Tanggal -->
                <div>
                    <label for="tanggal" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Tanggal Transaksi</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $transaksi->tanggal) }}" 
                           class="w-full text-xs rounded-xl border-[#E5E7EB] focus:border-[#2F5D34] focus:ring-[#2F5D34] shadow-sm" required>
                </div>

                <!-- Jenis -->
                <div>
                    <label for="jenis" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Jenis Transaksi</label>
                    <select name="jenis" id="jenis" 
                            class="w-full text-xs rounded-xl border-[#E5E7EB] focus:border-[#2F5D34] focus:ring-[#2F5D34] shadow-sm" required>
                        <option value="masuk" {{ old('jenis', $transaksi->jenis) == 'masuk' ? 'selected' : '' }}>Kas Masuk (Pemasukan)</option>
                        <option value="keluar" {{ old('jenis', $transaksi->jenis) == 'keluar' ? 'selected' : '' }}>Kas Keluar (Pengeluaran)</option>
                    </select>
                </div>

                <!-- Keterangan -->
                <div>
                    <label for="keterangan" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Keterangan / Deskripsi</label>
                    <input type="text" name="keterangan" id="keterangan" value="{{ old('keterangan', $transaksi->keterangan) }}" placeholder="Contoh: Iuran bulanan warga, pembayaran sampah"
                           class="w-full text-xs rounded-xl border-[#E5E7EB] focus:border-[#2F5D34] focus:ring-[#2F5D34] shadow-sm" required>
                </div>

                <!-- Nominal -->
                <div>
                    <label for="nominal" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nominal (Rp)</label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-400 text-xs">Rp</span>
                        </div>
                        <input type="number" name="nominal" id="nominal" value="{{ old('nominal', intval($transaksi->nominal)) }}" placeholder="0" min="0" step="any"
                               class="w-full pl-9 text-xs rounded-xl border-[#E5E7EB] focus:border-[#2F5D34] focus:ring-[#2F5D34] shadow-sm" required>
                    </div>
                </div>

                <!-- Submit & Cancel Button -->
                <div class="pt-4 border-t border-gray-100 flex items-center justify-end space-x-2">
                    <a href="{{ route('transaksi.index') }}" 
                       class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-5 py-2 bg-[#2F5D34] hover:bg-[#4F7A3F] text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-[#2F5D34]/15">
                        Update Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>