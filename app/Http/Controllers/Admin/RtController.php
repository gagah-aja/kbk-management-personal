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

        return view('pages.admin.rt.index', compact('dataRT'));
    }

    /**
     * Tampilkan form tambah RT
     */
    public function create()
    {
        // Ambil daftar RW untuk dropdown
        $rwList = Rw::all();

        // Ambil ID warga yang sudah menjadi RT
        $idWargaSudahRT = Rt::pluck('id_warga')->toArray();

        // Ambil warga yang belum menjadi RT
        $warga = Warga::whereNotIn('id', $idWargaSudahRT)->get();

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
            'nomor_rt' => 'required|string|max:10|unique:rt,nomor_rt',
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
        $rwList = Rw::all();

        // Ambil ID warga yang sudah menjadi RT (kecuali RT yang sedang diedit)
        $idWargaSudahRT = Rt::where('id', '!=', $id)->pluck('id_warga')->toArray();

        // Ambil warga yang belum menjadi RT + warga yang sedang menjadi RT ini
        $warga = Warga::whereNotIn('id', $idWargaSudahRT)->get();

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
            'nomor_rt' => 'required|string|max:10|unique:rt,nomor_rt,' . $rt->id,
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
            $rt->delete();

            return redirect()->route('admin.rt.index')
                ->with('success', 'Data RT berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.rt.index')
                ->with('error', 'Gagal menghapus data RT: ' . $e->getMessage());
        }
    }
}