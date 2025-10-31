<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blok;

class BlokController extends Controller
{
    // 🟢 Tampilkan semua blok
    public function index()
    {
        $bloks = Blok::orderBy('id', 'asc')->get();
        return view('pages.admin.nama-blok', compact('bloks'));
    }

    // 🟢 Simpan blok baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_blok' => 'required|string|max:255|unique:blok,nama_blok',
        ]);

        Blok::create([
            'nama_blok' => $request->nama_blok,
        ]);

        return redirect()->back()->with('success', 'Blok berhasil ditambahkan!');
    }

    // 🟡 Update data blok
    public function update(Request $request, $id)
    {
        $blok = Blok::findOrFail($id);

        $request->validate([
            'nama_blok' => 'required|string|max:255|unique:blok,nama_blok,' . $blok->id,
        ]);

        $blok->update([
            'nama_blok' => $request->nama_blok,
        ]);

        return redirect()->back()->with('success', 'Blok berhasil diperbarui!');
    }

    // 🔴 Hapus blok
    public function destroy($id)
    {
        $blok = Blok::findOrFail($id);
        $blok->delete();

        return redirect()->back()->with('success', 'Blok berhasil dihapus!');
    }
}
