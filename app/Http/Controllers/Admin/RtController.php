<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rt;
use App\Models\Warga;
use App\Models\Rw;

class RtController extends Controller
{
    /**
     * Menampilkan daftar RT
     */
    public function index()
    {
        // Ambil data RT beserta relasi warga & RW
        $dataRT = Rt::with(['warga', 'rw'])->get();

        // Ambil semua warga untuk dropdown Nama RT
        $warga = Warga::all();

        // Ambil semua RW untuk dropdown RW
        $rwList = Rw::all();

        return view('pages.admin.data-rt', compact('dataRT', 'warga', 'rwList'));
    }

    /**
     * Simpan data RT baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_warga' => 'required|exists:warga,id',
            'id_rw'    => 'required|exists:rw,id',
            'nomor_rt' => 'required|string|max:10',
        ]);

        Rt::create([
            'id_warga' => $request->id_warga,
            'id_rw'    => $request->id_rw,
            'nomor_rt' => $request->nomor_rt,
        ]);

        return redirect()->route('admin.data-rt.index')
                         ->with('success', '✅ Data RT berhasil ditambahkan!');
    }

    /**
     * Update data RT
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_warga' => 'required|exists:warga,id',
            'id_rw'    => 'required|exists:rw,id',
            'nomor_rt' => 'required|string|max:10',
        ]);

        $rt = Rt::findOrFail($id);
        $rt->update([
            'id_warga' => $request->id_warga,
            'id_rw'    => $request->id_rw,
            'nomor_rt' => $request->nomor_rt,
        ]);

        return redirect()->route('admin.data-rt.index')
                         ->with('success', '✅ Data RT berhasil diperbarui!');
    }

    /**
     * Hapus data RT
     */
    public function destroy($id)
    {
        $rt = Rt::findOrFail($id);
        $rt->delete();

        return redirect()->route('admin.data-rt.index')
                         ->with('success', '✅ Data RT berhasil dihapus!');
    }
}
