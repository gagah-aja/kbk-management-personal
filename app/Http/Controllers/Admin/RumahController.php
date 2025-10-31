<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rumah;
use App\Models\Cluster;
use App\Models\Warga;
use Illuminate\Support\Facades\Storage;

class RumahController extends Controller
{
    // 🟢 Tampilkan semua data rumah
    public function index()
    {
        $rumah = Rumah::with(['cluster', 'warga'])->get();
        return view('pages.admin.rumah.rumah', compact('rumah'));
    }

    // 🟡 Tampilkan form tambah rumah
    public function create()
    {
        $clusters = Cluster::all();
        $warga = Warga::all();
        return view('pages.admin.rumah.create', compact('clusters', 'warga'));
    }

    // 🟠 Simpan data rumah baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_rumah' => 'required|unique:rumah,nomor_rumah',
            'alamat_lengkap' => 'required',
            'status' => 'required|in:tersedia,terisi,rusak',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'latitude' => 'nullable',   
            'longitude' => 'nullable',
            'id_cluster' => 'required|exists:cluster,id',
            'id_warga' => 'nullable|exists:warga,id',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('rumah', 'public');
        }

        Rumah::create($validated);

        return redirect()->route('admin.rumah.index')
            ->with('success', 'Data rumah berhasil ditambahkan!');
    }

    // 🟣 Tampilkan form edit rumah
    public function edit($id)
    {
        $rumah = Rumah::findOrFail($id);
        $clusters = Cluster::all();
        $warga = Warga::all();

        return view('pages.admin.rumah.edit', compact('rumah', 'clusters', 'warga'));
    }

    // 🟡 Update data rumah
    public function update(Request $request, $id)
    {
        $rumah = Rumah::findOrFail($id);

        $validated = $request->validate([
            'nomor_rumah' => 'required|unique:rumah,nomor_rumah,' . $rumah->id,
            'alamat_lengkap' => 'required',
            'status' => 'required|in:Tersedia,Terisi,Rusak',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'id_cluster' => 'required|exists:cluster,id',
            'id_warga' => 'nullable|exists:warga,id',
        ]);

        // Ganti gambar jika diunggah baru
        if ($request->hasFile('gambar')) {
            if ($rumah->gambar) {
                Storage::disk('public')->delete($rumah->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('rumah', 'public');
        }

        $rumah->update($validated);

        return redirect()->route('admin.rumah.index')
            ->with('success', 'Data rumah berhasil diperbarui!');
    }

    // 🔴 Hapus data rumah
    public function destroy($id)
    {
        $rumah = Rumah::findOrFail($id);
        if ($rumah->gambar) {
            Storage::disk('public')->delete($rumah->gambar);
        }
        $rumah->delete();

        return redirect()->route('admin.rumah.index')
            ->with('success', 'Data rumah berhasil dihapus!');
    }
}
