<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class InventarisController extends Controller implements HasMiddleware
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
        // Hanya mengambil data inventaris milik RT user yang sedang login
        $inventarisList = Inventaris::where('rt_id', auth()->user()->rt_id)
            ->latest()
            ->get();

        return view('inventaris.index', compact('inventarisList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventaris.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input data inventaris
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tahun_perolehan' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'keterangan' => 'nullable|string',
        ]);

        // Menyimpan data inventaris otomatis dengan rt_id milik user yang sedang login
        Inventaris::create([
            'rt_id' => auth()->user()->rt_id,
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'kondisi' => $request->kondisi,
            'lokasi' => $request->lokasi,
            'tahun_perolehan' => $request->tahun_perolehan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('inventaris.index')
            ->with('success', 'Data inventaris berhasil ditambahkan.');
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
        // Mengambil data inventaris berdasarkan ID dan rt_id dari user yang login (isolasi data)
        $inventaris = Inventaris::where('rt_id', auth()->user()->rt_id)
            ->findOrFail($id);

        return view('inventaris.edit', compact('inventaris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi data input inventaris
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tahun_perolehan' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'keterangan' => 'nullable|string',
        ]);

        // Pastikan inventaris yang diupdate adalah milik RT yang sama
        $inventaris = Inventaris::where('rt_id', auth()->user()->rt_id)
            ->findOrFail($id);

        $inventaris->update([
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'kondisi' => $request->kondisi,
            'lokasi' => $request->lokasi,
            'tahun_perolehan' => $request->tahun_perolehan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('inventaris.index')
            ->with('success', 'Data inventaris berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Pastikan inventaris yang didelete adalah milik RT yang sama
        $inventaris = Inventaris::where('rt_id', auth()->user()->rt_id)
            ->findOrFail($id);

        $inventaris->delete();

        return redirect()
            ->route('inventaris.index')
            ->with('success', 'Data inventaris berhasil dihapus.');
    }
}
