<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cluster;
use App\Models\Rumah;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RumahController extends Controller
{
     public function index(Request $request)
    {
        $search = $request->input('search');

        $rumah = Rumah::with(['cluster', 'warga'])
            ->when($search, function ($query, $search) {
                $query->where('nomor_rumah', 'like', "%{$search}%")
                      ->orWhere('alamat_lengkap', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%");
            })
            ->paginate(10);

        $rumah->appends(['search' => $search]);

        return view('pages.admin.rumah', compact('rumah', 'search'));
    }

    /**
     * Form tambah rumah baru.
     */
    public function create()
    {
        $clusters = Cluster::all();
        $warga = Warga::all();
        return view('pages.admin.rumah.create', compact('clusters', 'warga'));
    }

    /**
     * Simpan data rumah baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_rumah' => 'required|unique:rumah,nomor_rumah',
            'alamat_lengkap' => 'required',
            'status' => 'required|in:tersedia,terisi,rusak',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'id_cluster' => 'required|exists:cluster,id',
            'id_warga' => 'nullable|exists:warga,id',
        ]);

        // Upload gambar kalau ada
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('rumah', 'public');
        }

        Rumah::create($validated);

        return redirect()->route('admin.rumah.index')->with('success', 'Data rumah berhasil ditambahkan.');
    }

    /**
     * Form edit rumah.
     */
    public function edit(Rumah $rumah)
    {
        $clusters = Cluster::all();
        $warga = Warga::all();
        return view('pages.admin.rumah.edit', compact('rumah', 'clusters', 'warga'));
    }

    /**
     * Update data rumah.
     */
    public function update(Request $request, Rumah $rumah)
    {
        $validated = $request->validate([
            'nomor_rumah' => 'required|unique:rumah,nomor_rumah,' . $rumah->id,
            'alamat_lengkap' => 'required',
            'status' => 'required|in:tersedia,terisi,rusak',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'id_cluster' => 'required|exists:cluster,id',
            'id_warga' => 'nullable|exists:warga,id',
        ]);

        // Ganti gambar kalau ada upload baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($rumah->gambar && Storage::disk('public')->exists($rumah->gambar)) {
                Storage::disk('public')->delete($rumah->gambar);
            }

            $validated['gambar'] = $request->file('gambar')->store('rumah', 'public');
        }

        $rumah->update($validated);

        return redirect()->route('admin.rumah.index')->with('success', 'Data rumah berhasil diperbarui.');
    }

    /**
     * Hapus data rumah.
     */
    public function destroy(Rumah $rumah)
    {
        if ($rumah->gambar && Storage::disk('public')->exists($rumah->gambar)) {
            Storage::disk('public')->delete($rumah->gambar);
        }

        $rumah->delete();

        return redirect()->route('admin.rumah.index')->with('success', 'Data rumah berhasil dihapus.');
    }
}
