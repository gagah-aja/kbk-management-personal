<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blok;

class BlokController extends Controller
{
    /**
     * Tampilkan semua blok
     */
    public function index(Request $request)
{
    $search = $request->input('search');

    $bloks = \App\Models\Blok::when($search, function ($query, $search) {
            $query->where('nama_blok', 'like', "%{$search}%");
        })
        ->orderBy('nama_blok', 'asc')
        ->paginate(10)
        ->withQueryString(); // agar query search tetap terbawa saat pindah halaman

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
            
            // Cek apakah blok sedang digunakan
            if ($blok->clusters()->count() > 0) {
                return redirect()->route('admin.blok.index')
                    ->with('error', 'Blok tidak dapat dihapus karena masih digunakan oleh cluster.');
            }
            
            $blok->delete();
            return redirect()->route('admin.blok.index')
                ->with('success', 'Blok berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.blok.index')
                ->with('error', 'Gagal menghapus blok: ' . $e->getMessage());
        }
    }
}