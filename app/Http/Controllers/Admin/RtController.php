<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rt;
use App\Models\Warga;
use App\Models\Rw;
use Illuminate\Support\Facades\DB;

class RtController extends Controller
{
    /**
     * Menampilkan daftar RT
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $dataRT = Rt::with(['warga', 'rw'])
            ->when($search, function ($query, $search) {
                $query->where('nomor_rt', 'like', "%{$search}%")
                      ->orWhereHas('warga', function ($q) use ($search) {
                          $q->where('nama_lengkap', 'like', "%{$search}%")
                            ->orWhere('nik', 'like', "%{$search}%");
                      })
                      ->orWhereHas('rw', function ($q) use ($search) {
                          $q->where('nomor_rw', 'like', "%{$search}%");
                      });
            })
            ->orderBy('nomor_rt', 'asc')
            ->paginate(10);

        $dataRT->appends(['search' => $search]);

        return view('pages.admin.rt.index', compact('dataRT', 'search'));
    }

    /**
     * Tampilkan form tambah RT
     */
    public function create()
    {
        // Ambil ID warga yang sudah menjadi RT
        $idWargaSudahRT = Rt::pluck('id_warga')->toArray();

        // Ambil ID warga yang sudah menjadi RW
        $idWargaSudahRW = Rw::pluck('id_warga')->toArray();

        // Gabungkan keduanya agar tidak bisa dipilih lagi
        $idTerkunci = array_merge($idWargaSudahRT, $idWargaSudahRW);

        // Ambil warga yang belum menjadi RT maupun RW
        $warga = Warga::whereNotIn('id', $idTerkunci)
            ->orderBy('nama_lengkap', 'asc')
            ->get();

        // Ambil daftar RW untuk dropdown
        $rwList = Rw::orderBy('nomor_rw', 'asc')->get();

        return view('pages.admin.rt.create', compact('warga', 'rwList'));
    }

    /**
     * Menyimpan data RT baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_warga' => 'required|exists:warga,id|unique:rt,id_warga',
            'id_rw'    => 'required|exists:rw,id',
            'nomor_rt' => 'required|digits_between:1,3|unique:rt,nomor_rt',
        ], [
            'id_warga.required' => 'Ketua RT wajib dipilih.',
            'id_warga.exists' => 'Warga tidak ditemukan.',
            'id_warga.unique' => 'Warga ini sudah menjadi ketua RT.',
            'id_rw.required' => 'RW wajib dipilih.',
            'id_rw.exists' => 'RW tidak ditemukan.',
            'nomor_rt.required' => 'Nomor RT wajib diisi.',
            'nomor_rt.unique' => 'Nomor RT sudah terdaftar.',
        ]);

        Rt::create([
            'id_warga' => $request->id_warga,
            'id_rw'    => $request->id_rw,
            'nomor_rt' => $request->nomor_rt,
        ]);

        return redirect()->route('admin.rt.index')
            ->with('success', 'Data RT berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit RT
     */
    public function edit($id)
    {
        $rt = Rt::with(['warga', 'rw'])->findOrFail($id);

        // Ambil daftar RW untuk dropdown
        $rwList = Rw::orderBy('nomor_rw', 'asc')->get();

        // Ambil ID warga yang sudah menjadi RT (kecuali RT yang sedang diedit)
        $idWargaSudahRT = Rt::where('id', '!=', $id)->pluck('id_warga')->toArray();

        // Ambil ID warga yang sudah menjadi RW
        $idWargaSudahRW = Rw::pluck('id_warga')->toArray();

        // Gabungkan (kecuali warga RT yang sedang diedit)
        $idTerkunci = array_merge($idWargaSudahRT, $idWargaSudahRW);

        // Ambil warga yang belum menjadi RT/RW + warga yang sedang menjadi RT ini
        $warga = Warga::whereNotIn('id', $idTerkunci)
            ->orWhere('id', $rt->id_warga)
            ->orderBy('nama_lengkap', 'asc')
            ->get();

        return view('pages.admin.rt.edit', compact('rt', 'warga', 'rwList'));
    }

    /**
     * Memperbarui data RT
     */
    public function update(Request $request, $id)
    {
        $rt = Rt::findOrFail($id);

        $request->validate([
            'id_warga' => 'required|exists:warga,id|unique:rt,id_warga,' . $rt->id,
            'id_rw'    => 'required|exists:rw,id',
            'nomor_rt' => 'required|digits_between:1,3|unique:rt,nomor_rt,' . $rt->id,
        ], [
            'id_warga.required' => 'Ketua RT wajib dipilih.',
            'id_warga.exists' => 'Warga tidak ditemukan.',
            'id_warga.unique' => 'Warga ini sudah menjadi ketua RT.',
            'id_rw.required' => 'RW wajib dipilih.',
            'id_rw.exists' => 'RW tidak ditemukan.',
            'nomor_rt.required' => 'Nomor RT wajib diisi.',
            'nomor_rt.unique' => 'Nomor RT sudah terdaftar.',
        ]);

        $rt->update([
            'id_warga' => $request->id_warga,
            'id_rw'    => $request->id_rw,
            'nomor_rt' => $request->nomor_rt,
        ]);

        return redirect()->route('admin.rt.index')
            ->with('success', 'Data RT berhasil diperbarui!');
    }

    /**
     * Menghapus data RT
     */
    public function destroy($id)
{
    try {
        $rt = Rt::findOrFail($id);

        // Cek apakah RT sedang digunakan oleh cluster
        if ($rt->clusters()->count() > 0) {
            // Kembalikan response JSON agar bisa ditangani SweetAlert
            return response()->json([
                'status' => 'error',
                'message' => 'RT tidak dapat dihapus karena masih digunakan oleh cluster.',
                'clusterUrl' => route('admin.cluster.index') . '?search=' . $rt->id
            ]);
        }

        $rt->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data RT berhasil dihapus.'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ]);
    }
}


}