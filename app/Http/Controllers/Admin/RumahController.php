<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rumah;
use App\Models\Cluster;
use App\Models\Warga;
use App\Models\StatusRumah;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class RumahController extends Controller
{
    /**
     * Tampilkan semua data rumah
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $rumah = Rumah::with([
            'cluster.namaCluster',
            'cluster.rt',
            'cluster.blok',
            'warga',
            'statusRumah',
            'penghuniAktif.warga'
        ])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nomor_rumah', 'like', "%{$search}%")
                        ->orWhere('alamat_lengkap', 'like', "%{$search}%")
                        ->orWhereHas('cluster.namaCluster', function ($sub) use ($search) {
                            $sub->where('nama_cluster', 'like', "%{$search}%");
                        })
                        ->orWhereHas('penghuniAktif.warga', function ($sub) use ($search) {
                            $sub->where('nama_lengkap', 'like', "%{$search}%");
                        })
                        ->orWhereHas('statusRumah', function ($sub) use ($search) {
                            $sub->where('nama_status', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(12);

        $rumah->appends(['search' => $search]);

        return view('pages.admin.rumah.index', compact('rumah', 'search'));
    }

    /**
     * Tampilkan form tambah rumah
     */
    public function create()
    {
        $clusters = Cluster::with(['namaCluster', 'rt', 'blok'])->get();
        $warga = Warga::all();
        $status_rumah = StatusRumah::all();
        return view('pages.admin.rumah.create', compact('clusters', 'warga', 'status_rumah'));
    }

    /**
     * Simpan data rumah baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_rumah' => 'required|string|max:50|unique:rumah,nomor_rumah',
            'alamat_lengkap' => 'required|string',
            'id_status_rumah' => 'required|exists:status_rumah,id',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'id_cluster' => 'required|exists:cluster,id',
            'id_warga' => 'nullable|exists:warga,id',
        ], [
            'nomor_rumah.required' => 'Nomor rumah wajib diisi.',
            'nomor_rumah.unique' => 'Nomor rumah sudah terdaftar.',
            'alamat_lengkap.required' => 'Alamat lengkap wajib diisi.',
            'id_status_rumah.required' => 'Status rumah wajib dipilih.',
            'id_cluster.required' => 'Cluster wajib dipilih.',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('rumah', 'public');
        }

        $rumah = Rumah::create($validated);

        // Cek apakah user ingin langsung tambah penghuni
        if ($request->has('tambah_penghuni') && $request->tambah_penghuni == '1') {
            return redirect()->route('admin.rumah.penghuni.create', $rumah->id)
                ->with('success', 'Data rumah berhasil ditambahkan! Silakan tambahkan penghuni.');
        }

        // Jika tidak, kembali ke index
        return redirect()->route('admin.rumah.index')
            ->with('success', 'Data rumah berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit rumah
     */
    public function edit($id)
    {
        $rumah = Rumah::with(['cluster', 'warga', 'statusRumah'])->findOrFail($id);
        $clusters = Cluster::with(['namaCluster', 'rt', 'blok'])->get();
        $warga = Warga::all();
        $status_rumah = StatusRumah::all();
        return view('pages.admin.rumah.edit', compact('rumah', 'clusters', 'warga', 'status_rumah'));
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
            'id_status_rumah' => 'required|exists:status_rumah,id',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'id_cluster' => 'required|exists:cluster,id',
            'id_warga' => 'nullable|exists:warga,id',
        ], [
            'nomor_rumah.required' => 'Nomor rumah wajib diisi.',
            'nomor_rumah.unique' => 'Nomor rumah sudah terdaftar.',
            'alamat_lengkap.required' => 'Alamat lengkap wajib diisi.',
            'id_status_rumah.required' => 'Status rumah wajib dipilih.',
            'id_cluster.required' => 'Cluster wajib dipilih.',
        ]);

        if ($request->hasFile('gambar')) {
            if ($rumah->gambar) {
                Storage::disk('public')->delete($rumah->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('rumah', 'public');
        }

        $rumah->update($validated);
        return redirect()->route('admin.rumah.index')->with('success', 'Data rumah berhasil diperbarui!');
    }

    /**
     * Hapus data rumah
     */
    public function destroy($id)
    {
        try {
            $rumah = Rumah::findOrFail($id);

            // Cek apakah rumah masih memiliki penghuni aktif
            if ($rumah->penghuniAktif()->count() > 0) {
                return redirect()->route('admin.rumah.index')
                    ->with('error', 'Rumah tidak dapat dihapus karena masih memiliki penghuni aktif.');
            }

            if ($rumah->gambar) {
                Storage::disk('public')->delete($rumah->gambar);
            }

            $rumah->delete();

            // Reset auto increment jika tabel kosong
            if (Rumah::count() === 0) {
                DB::statement('ALTER TABLE rumah AUTO_INCREMENT = 1;');
            }

            return redirect()->route('admin.rumah.index')->with('success', 'Data rumah berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.rumah.index')->with('error', 'Gagal menghapus data rumah: ' . $e->getMessage());
        }
    }
}