<x-app-layout>

    <div class="p-6">

        <h1 class="text-2xl font-bold mb-4">
            Data Kas RT
        </h1>

        <a href="{{ route('transaksi.create') }}"
           class="bg-blue-500 text-white px-4 py-2 rounded">
           Tambah Transaksi
        </a>

        <table class="mt-4 w-full border">

            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Keterangan</th>
                    <th>Nominal</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($transaksis as $transaksi)

                <tr>
                    <td>{{ $transaksi->tanggal }}</td>
                    <td>{{ $transaksi->jenis }}</td>
                    <td>{{ $transaksi->keterangan }}</td>
                    <td>Rp {{ number_format($transaksi->nominal,0,',','.') }}</td>
                    <td>

                        <a href="{{ route('transaksi.edit', $transaksi->id) }}">
                            Edit
                        </a>

                        |

                        <form action="{{ route('transaksi.destroy', $transaksi->id) }}"
                            method="POST"
                            style="display:inline;">

                            @csrf
                            @method('DELETE')

                            <button type="submit">
                                Hapus
                            </button>

                        </form>

                    </td>
                </tr>

                @empty

                <tr>
                    <td colspan="4">
                        Belum ada transaksi
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</x-app-layout>