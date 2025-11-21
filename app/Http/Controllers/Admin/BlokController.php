<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cluster;
use App\Models\Blok;
use App\Models\Rumah;
use Illuminate\Support\Facades\DB;

class BlokController extends Controller
{
    /**
     * Tampilkan semua blok
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $bloks = Blok::when($search, function ($query, $search) {
                $query->where('nama_blok', 'like', "%{$search}%");
            })
            ->orderBy('nama_blok', 'asc')
            ->paginate(10);

        $bloks->appends(['search' => $search]);

        return view('pages.admin.blok.index', compact('bloks', 'search'));
    }

    /**
     * Tampilkan form tambah blok
     */
    public function create()
    {
        return view('pages.admin.blok.create');
    }

    /**
     * Simpan blok baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_blok' => 'required|string|max:255|unique:blok,nama_blok',
        ], [
            'nama_blok.required' => 'Nama blok wajib diisi.',
            'nama_blok.unique' => 'Nama blok sudah terdaftar.',
        ]);

        Blok::create([
            'nama_blok' => $request->nama_blok,
        ]);

        return redirect()->route('admin.blok.index')
            ->with('success', 'Blok berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit blok
     */
    public function edit($id)
    {
        $blok = Blok::findOrFail($id);
        return view('pages.admin.blok.edit', compact('blok'));
    }

    /**
     * Update data blok
     */
    public function update(Request $request, $id)
    {
        $blok = Blok::findOrFail($id);

        $request->validate([
            'nama_blok' => 'required|string|max:255|unique:blok,nama_blok,' . $blok->id,
        ], [
            'nama_blok.required' => 'Nama blok wajib diisi.',
            'nama_blok.unique' => 'Nama blok sudah terdaftar.',
        ]);

        $blok->update([
            'nama_blok' => $request->nama_blok,
        ]);

        return redirect()->route('admin.blok.index')
            ->with('success', 'Blok berhasil diperbarui!');
    }

    /**
     * Hapus blok
     */
    public function destroy($id)
{
    try {
        $blok = Blok::findOrFail($id);

        // Ambil semua cluster yang menggunakan blok ini
        $clusterIds = Cluster::where('id_blok', $id)->pluck('id');

        // Cek apakah ada rumah pada cluster tersebut
        $dipakaiRumah = Rumah::whereIn('id_cluster', $clusterIds)->count();

        if ($dipakaiRumah > 0) {
            return redirect()->route('admin.blok.index')
                ->with('error', 'Blok tidak bisa dihapus karena masih digunakan oleh rumah melalui data cluster.')
                ->with('cluster_redirect', route('admin.cluster.index')); // untuk tombol cek cluster
        }

        // Jika aman → hapus blok
        $blok->delete();

        // Reset auto increment jika tabel kosong
        if (Blok::count() === 0) {
            DB::statement('ALTER TABLE blok AUTO_INCREMENT = 1;');
        }

        return redirect()->route('admin.blok.index')
            ->with('success', 'Blok berhasil dihapus!');
            
    } catch (\Exception $e) {
        return redirect()->route('admin.blok.index')
            ->with('error', 'Gagal menghapus blok: ' . $e->getMessage());
    }
}




}