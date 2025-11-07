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
    /**
     * Tampilkan semua data rumah
     */
    public function index()
    {
        $rumah = Rumah::with(['cluster.namaCluster', 'cluster.rt', 'cluster.blok', 'warga'])->get();
        return view('pages.admin.rumah.index', compact('rumah'));
    }

    /**
     * Tampilkan form tambah rumah
     */
    public function create()
    {
        $clusters = Cluster::with(['namaCluster', 'rt', 'blok'])->get();
        $warga = Warga::all();
        return view('pages.admin.rumah.create', compact('clusters', 'warga'));
    }

    /**
     * Simpan data rumah baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_rumah' => 'required|string|max:50|unique:rumah,nomor_rumah',
            'alamat_lengkap' => 'required|string',
            'status' => 'required|in:tersedia,terisi,rusak',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'latitude' => 'nullable|numeric',   
            'longitude' => 'nullable|numeric',
            'id_cluster' => 'required|exists:cluster,id',
            'id_warga' => 'nullable|exists:warga,id',
        ], [
            'nomor_rumah.required' => 'Nomor rumah wajib diisi.',
            'nomor_rumah.unique' => 'Nomor rumah sudah terdaftar.',
            'alamat_lengkap.required' => 'Alamat lengkap wajib diisi.',
            'status.required' => 'Status rumah wajib dipilih.',
            'status.in' => 'Status tidak valid.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus berformat JPG, JPEG, atau PNG.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
            'id_cluster.required' => 'Cluster wajib dipilih.',
            'id_cluster.exists' => 'Cluster tidak valid.',
            'id_warga.exists' => 'Warga tidak valid.',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('rumah', 'public');
        }

        Rumah::create($validated);

        return redirect()->route('admin.rumah.index')
            ->with('success', 'Data rumah berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit rumah
     */
    public function edit($id)
    {
        $rumah = Rumah::with(['cluster', 'warga'])->findOrFail($id);
        $clusters = Cluster::with(['namaCluster', 'rt', 'blok'])->get();
        $warga = Warga::all();

        return view('pages.admin.rumah.edit', compact('rumah', 'clusters', 'warga'));
    }

    /**
     * Update data rumah
     */
    public function update(Request $request, $id)
    {
        $rumah = Rumah::findOrFail($id);

        $validated = $request->validate([
            'nomor_rumah' => 'required|string|max:50|unique:rumah,nomor_rumah,' . $rumah->id,
            'alamat_lengkap' => 'required|string',
            'status' => 'required|in:tersedia,terisi,rusak',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'id_cluster' => 'required|exists:cluster,id',
            'id_warga' => 'nullable|exists:warga,id',
        ], [
            'nomor_rumah.required' => 'Nomor rumah wajib diisi.',
            'nomor_rumah.unique' => 'Nomor rumah sudah terdaftar.',
            'alamat_lengkap.required' => 'Alamat lengkap wajib diisi.',
            'status.required' => 'Status rumah wajib dipilih.',
            'status.in' => 'Status tidak valid.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus berformat JPG, JPEG, atau PNG.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
            'id_cluster.required' => 'Cluster wajib dipilih.',
            'id_cluster.exists' => 'Cluster tidak valid.',
            'id_warga.exists' => 'Warga tidak valid.',
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

    /**
     * Hapus data rumah
     */
    public function destroy($id)
    {
        try {
            $rumah = Rumah::findOrFail($id);
            
            // Hapus gambar jika ada
            if ($rumah->gambar) {
                Storage::disk('public')->delete($rumah->gambar);
            }
            
            $rumah->delete();

            return redirect()->route('admin.rumah.index')
                ->with('success', 'Data rumah berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.rumah.index')
                ->with('error', 'Gagal menghapus data rumah: ' . $e->getMessage());
        }
    }
}