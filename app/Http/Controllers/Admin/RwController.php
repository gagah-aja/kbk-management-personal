<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rw;
use App\Models\Warga;

class RwController extends Controller
{
    // 🟢 Tampilkan semua data RW
    public function index()
    {
        $rws = Rw::with('warga')->get();
        $wargas = Warga::all(); // untuk dropdown tambah/edit
        return view('pages.admin.data-rw', compact('rws', 'wargas'));
    }

    // 🟢 Simpan Data RW Baru
    public function store(Request $request)
    {
        $request->validate([
            'nomor_rw' => 'required|numeric|unique:rw,nomor_rw',
            'id_warga' => 'required|exists:warga,id|unique:rw,id_warga',
        ], [
            'nomor_rw.required' => 'Nomor RW wajib diisi.',
            'nomor_rw.numeric' => 'Nomor RW harus berupa angka.',
            'nomor_rw.unique' => 'Nomor RW sudah terdaftar.',
            'id_warga.required' => 'Ketua RW harus dipilih.',
            'id_warga.exists' => 'Warga tidak ditemukan.',
            'id_warga.unique' => 'Warga ini sudah menjadi ketua RW lain.',
        ]);

        Rw::create($request->only('nomor_rw', 'id_warga'));

        return redirect()->back()->with('success', 'Data RW berhasil ditambahkan!');
    }

    // 🟡 Update Data RW
    public function update(Request $request, $id)
    {
        // Ambil data RW (404 jika tidak ditemukan)
        $rw = Rw::findOrFail($id);

        try {
            // Validasi input
            $request->validate([
                'nomor_rw' => 'required|numeric|unique:rw,nomor_rw,' . $rw->id,
                'id_warga' => 'required|exists:warga,id|unique:rw,id_warga,' . $rw->id,
            ], [
                'nomor_rw.required' => 'Nomor RW wajib diisi.',
                'nomor_rw.numeric' => 'Nomor RW harus berupa angka.',
                'nomor_rw.unique' => 'Nomor RW sudah terdaftar.',
                'id_warga.required' => 'Ketua RW harus dipilih.',
                'id_warga.exists' => 'Warga tidak ditemukan.',
                'id_warga.unique' => 'Warga ini sudah menjadi ketua RW lain.',
            ]);

            // Update data RW
            $rw->update($request->only('nomor_rw', 'id_warga'));

            // Ambil ulang relasi warga agar data baru ikut terkirim
            $rw->load('warga');

            // Kembalikan response JSON
          return redirect()->back()->with('success', 'Data RW berhasil diperbarui!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Jika validasi gagal, kirim error JSON juga
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Jika ada error lain
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



    // 🔴 Hapus RW
    public function destroy($id)
    {
        $rw = Rw::findOrFail($id);
        $rw->delete();

        return redirect()->route('admin.rw.index')->with('success', 'Data RW berhasil dihapus.');
    }

}
