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
        // Ambil data RT beserta relasi Warga dan RW
        $dataRT = Rt::with(['warga', 'rw'])->get();

        // Ambil daftar RW untuk dropdown
        $rwList = Rw::all();

        // Ambil ID warga yang sudah menjadi RT
        $idWargaSudahRT = Rt::pluck('id_warga')->toArray();

        // Ambil semua data warga untuk dropdown
        $warga = Warga::all();

        return view('pages.admin.data-rt', compact('dataRT', 'warga', 'rwList', 'idWargaSudahRT'));
    }

    /**
     * Menyimpan data RT baru
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

        return redirect()
            ->route('admin.data-rt.index')
            ->with('success', '✅ Data RT berhasil ditambahkan!');
    }

    /**
     * Memperbarui data RT
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

        return redirect()
            ->route('admin.data-rt.index')
            ->with('success', '✅ Data RT berhasil diperbarui!');
    }

    /**
     * Menghapus data RT
     */
    public function destroy($id)
    {
        $rt = Rt::findOrFail($id);
        $rt->delete();

        return redirect()
            ->route('admin.data-rt.index')
            ->with('success', '✅ Data RT berhasil dihapus!');
    }
}
