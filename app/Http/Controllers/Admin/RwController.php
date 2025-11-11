<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rw;
use App\Models\Warga;

class RwController extends Controller
{
    /**
     * Menampilkan daftar RW
     */
    public function index()
    {
        // Ambil data RW beserta relasi Warga
        $dataRW = Rw::with('warga')->get();

        return view('pages.admin.rw.index', compact('dataRW'));
    }

    /**
     * Tampilkan form tambah RW
     */
    public function create()
    {
        // Ambil ID warga yang sudah menjadi RW
        $idWargaSudahRW = Rw::pluck('id_warga')->toArray();

        // Ambil warga yang belum menjadi RW
        $warga = Warga::whereNotIn('id', $idWargaSudahRW)->get();

        return view('pages.admin.rw.create', compact('warga'));
    }

    /**
     * Menyimpan data RW baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_warga' => 'required|exists:warga,id|unique:rw,id_warga',
            'nomor_rw' => 'required|digits_between:1,3|unique:rw,nomor_rw'
        ], [
            'id_warga.required' => 'Ketua RW wajib dipilih.',
            'id_warga.exists' => 'Warga tidak ditemukan.',
            'id_warga.unique' => 'Warga ini sudah menjadi ketua RW.',
            'nomor_rw.required' => 'Nomor RW wajib diisi.',
            'nomor_rw.unique' => 'Nomor RW sudah terdaftar.',
        ]);

        Rw::create([
            'id_warga' => $request->id_warga,
            'nomor_rw' => $request->nomor_rw,
        ]);

        return redirect()->route('admin.rw.index')
            ->with('success', 'Data RW berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit RW
     */
    public function edit($id)
    {
        $rw = Rw::with('warga')->findOrFail($id);

        // Ambil ID warga yang sudah menjadi RW (kecuali RW yang sedang diedit)
        $idWargaSudahRW = Rw::where('id', '!=', $id)->pluck('id_warga')->toArray();

        // Ambil warga yang belum menjadi RW + warga yang sedang menjadi RW ini
        $warga = Warga::whereNotIn('id', $idWargaSudahRW)->get();

        return view('pages.admin.rw.edit', compact('rw', 'warga'));
    }

    /**
     * Memperbarui data RW
     */
    public function update(Request $request, $id)
    {
        $rw = Rw::findOrFail($id);

        $request->validate([
            'id_warga' => 'required|exists:warga,id|unique:rw,id_warga,' . $rw->id,
            'nomor_rw' => 'required|string|max:10|unique:rw,nomor_rw,' . $rw->id,
        ], [
            'id_warga.required' => 'Ketua RW wajib dipilih.',
            'id_warga.exists' => 'Warga tidak ditemukan.',
            'id_warga.unique' => 'Warga ini sudah menjadi ketua RW.',
            'nomor_rw.required' => 'Nomor RW wajib diisi.',
            'nomor_rw.unique' => 'Nomor RW sudah terdaftar.',
        ]);

        $rw->update([
            'id_warga' => $request->id_warga,
            'nomor_rw' => $request->nomor_rw,
        ]);

        return redirect()->route('admin.rw.index')
            ->with('success', 'Data RW berhasil diperbarui!');
    }

    /**
     * Menghapus data RW
     */
    public function destroy($id)
    {
        try {
            $rw = Rw::findOrFail($id);

            // Cek apakah RW sedang digunakan oleh RT
            if ($rw->rts()->count() > 0) {
                return redirect()->route('admin.rw.index')
                    ->with('error', 'RW tidak dapat dihapus karena masih memiliki RT.');
            }

            $rw->delete();

            return redirect()->route('admin.rw.index')
                ->with('success', 'Data RW berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.rw.index')
                ->with('error', 'Gagal menghapus data RW: ' . $e->getMessage());
        }
    }
}
