<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TransaksiController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            // Membatasi aksi tulis (create, store, edit, update, destroy) hanya untuk role 'admin'
            new Middleware('admin', except: ['index', 'show']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksis = Transaksi::where(
            'rt_id',
            auth()->user()->rt_id
        )->latest()->get();

        return view(
            'transaksi.index',
            compact('transaksis')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transaksi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Tambahkan validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:masuk,keluar',
            'keterangan' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:0',
        ]);

        Transaksi::create([
            'rt_id' => auth()->user()->rt_id,
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'keterangan' => $request->keterangan,
            'nominal' => $request->nominal,
        ]);

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi kas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Pastikan hanya bisa mengedit transaksi milik RT sendiri
        $transaksi = Transaksi::where('rt_id', auth()->user()->rt_id)
            ->findOrFail($id);

        return view(
            'transaksi.edit',
            compact('transaksi')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Tambahkan validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:masuk,keluar',
            'keterangan' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:0',
        ]);

        // Pastikan transaksi milik RT sendiri
        $transaksi = Transaksi::where('rt_id', auth()->user()->rt_id)
            ->findOrFail($id);

        $transaksi->update([
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'keterangan' => $request->keterangan,
            'nominal' => $request->nominal,
        ]);

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi kas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Pastikan transaksi milik RT sendiri
        $transaksi = Transaksi::where('rt_id', auth()->user()->rt_id)
            ->findOrFail($id);

        $transaksi->delete();

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi kas berhasil dihapus.');
    }
}
