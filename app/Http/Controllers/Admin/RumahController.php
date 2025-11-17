<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rumah;
use App\Models\Cluster;
use App\Models\Warga;
use App\Models\StatusRumah;
use App\Models\Penghuni;
use Illuminate\Support\Facades\Storage;

class RumahController extends Controller
{
    /**
     * Tampilkan semua data rumah
     */
    public function index(Request $request)
    {
        $query = Rumah::with([
            'cluster.namaCluster', 
            'cluster.rt', 
            'cluster.blok', 
            'warga', 
            'statusRumah',
            'penghuniAktif.warga' // ⭐ Load penghuni aktif
        ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_rumah', 'like', "%{$search}%")
                  ->orWhere('alamat_lengkap', 'like', "%{$search}%")
                  ->orWhereHas('cluster.namaCluster', function($sub) use ($search) {
                      $sub->where('nama_cluster', 'like', "%{$search}%");
                  })
                  ->orWhereHas('penghuniAktif.warga', function($sub) use ($search) {
                      $sub->where('nama_lengkap', 'like', "%{$search}%");
                  })
                  ->orWhereHas('statusRumah', function($sub) use ($search) {
                      $sub->where('nama_status', 'like', "%{$search}%");
                  });
            });
        }

        $rumah = $query->orderBy('id', 'desc')->paginate(10);
        return view('pages.admin.rumah.index', compact('rumah'));
    }

    public function create()
    {
        $clusters = Cluster::with(['namaCluster', 'rt', 'blok'])->get();
        $warga = Warga::all();
        $status_rumah = StatusRumah::all();
        return view('pages.admin.rumah.create', compact('clusters', 'warga', 'status_rumah'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'nomor_rumah' => 'required|integer|min:1|unique:rumah,nomor_rumah',
        'alamat_lengkap' => 'required|string',
        'id_status_rumah' => 'required|exists:status_rumah,id',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'latitude' => 'nullable|numeric|between:-90,90',
        'longitude' => 'nullable|numeric|between:-180,180',
        'id_cluster' => 'required|exists:cluster,id',
        'id_warga' => 'nullable|exists:warga,id',
    ]);

    if ($request->hasFile('gambar')) {
        $validated['gambar'] = $request->file('gambar')->store('rumah', 'public');
    }

    Rumah::create($validated);

    return redirect()->route('admin.rumah.index')->with('success', 'Data rumah berhasil ditambahkan!');
}

    public function edit($id)
    {
        $rumah = Rumah::with(['cluster', 'warga', 'statusRumah'])->findOrFail($id);
        $clusters = Cluster::with(['namaCluster', 'rt', 'blok'])->get();
        $warga = Warga::all();
        $status_rumah = StatusRumah::all();
        return view('pages.admin.rumah.edit', compact('rumah', 'clusters', 'warga', 'status_rumah'));
    }

    
public function update(Request $request, $id)
{
    $rumah = Rumah::findOrFail($id);

    $validated = $request->validate([
        'nomor_rumah' => [
            'required',
            'integer',
            'min:1',
            Rule::unique('rumah', 'nomor_rumah')->ignore($id),
        ],
        'alamat_lengkap' => 'required|string',
        'id_status_rumah' => 'required|exists:status_rumah,id',
        'id_cluster' => 'required|exists:cluster,id',
        'id_warga' => 'nullable|exists:warga,id',
        'latitude' => 'nullable|numeric|between:-90,90',
        'longitude' => 'nullable|numeric|between:-180,180',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $rumah->update([
        'nomor_rumah' => $validated['nomor_rumah'],
        'alamat_lengkap' => $validated['alamat_lengkap'],
        'id_status_rumah' => $validated['id_status_rumah'],
        'id_cluster' => $validated['id_cluster'],
        'id_warga' => $validated['id_warga'] ?? null,
        'latitude' => $validated['latitude'] ?? null,
        'longitude' => $validated['longitude'] ?? null,
    ]);

    if ($request->hasFile('gambar')) {
        if ($rumah->gambar && Storage::disk('public')->exists($rumah->gambar)) {
            Storage::disk('public')->delete($rumah->gambar);
        }
        $rumah->gambar = $request->file('gambar')->store('rumah', 'public');
        $rumah->save();
    }

    return redirect()->route('admin.rumah.index')->with('success', 'Data rumah berhasil diperbarui!');
}

    public function destroy($id)
    {
        try {
            $rumah = Rumah::findOrFail($id);
            if ($rumah->gambar) {
                Storage::disk('public')->delete($rumah->gambar);
            }
            $rumah->delete();
            return redirect()->route('admin.rumah.index')->with('success', 'Data rumah berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.rumah.index')->with('error', 'Gagal menghapus data rumah: ' . $e->getMessage());
        }
    }

    // ========================================
    // ⭐ FITUR BARU: CRUD PENGHUNI
    // ========================================

    /**
     * ⭐ Tampilkan halaman list penghuni per rumah
     */
    public function showPenghuni($id_rumah)
    {
        $rumah = Rumah::with([
            'cluster.namaCluster',
            'cluster.rt',
            'cluster.blok'
        ])->findOrFail($id_rumah);

        // Ambil semua penghuni (aktif & tidak aktif) dengan warga
        $penghuni = Penghuni::with('warga')
            ->where('id_rumah', $id_rumah)
            ->orderBy('is_active', 'desc')
            ->orderBy('tanggal_masuk', 'desc')
            ->get();

        return view('pages.admin.rumah.show-penghuni', compact('rumah', 'penghuni'));
    }

    /**
     * Tampilkan form tambah penghuni (Modal atau Halaman)
     */
    public function createPenghuni($id_rumah)
    {
        $rumah = Rumah::findOrFail($id_rumah);
        $warga = Warga::all();
        return view('pages.admin.rumah.create-penghuni', compact('rumah', 'warga'));
    }

    /**
     * Simpan penghuni baru
     */
    public function storePenghuni(Request $request, $id_rumah)
    {
        $validated = $request->validate([
            'id_warga' => 'required|exists:warga,id',
            'tipe_penghuni' => 'required|in:Pemilik,Penyewa',
            'status_penghuni' => 'required|in:Kepala Keluarga,Istri/Suami,Anak,Orang Tua,Keluarga Lainnya',
            'tanggal_masuk' => 'required|date',
            'keterangan' => 'nullable|string',
        ], [
            'id_warga.required' => 'Warga wajib dipilih',
            'tipe_penghuni.required' => 'Tipe penghuni wajib dipilih',
            'status_penghuni.required' => 'Status penghuni wajib dipilih',
            'tanggal_masuk.required' => 'Tanggal masuk wajib diisi',
        ]);

        // Cek apakah warga sudah jadi penghuni aktif di rumah ini
        $existingPenghuni = Penghuni::where('id_rumah', $id_rumah)
            ->where('id_warga', $validated['id_warga'])
            ->where('is_active', true)
            ->first();

        if ($existingPenghuni) {
            return back()->with('error', 'Warga ini sudah terdaftar sebagai penghuni aktif di rumah ini!');
        }

        Penghuni::create([
            'id_rumah' => $id_rumah,
            'id_warga' => $validated['id_warga'],
            'tipe_penghuni' => $validated['tipe_penghuni'],
            'status_penghuni' => $validated['status_penghuni'],
            'tanggal_masuk' => $validated['tanggal_masuk'],
            'keterangan' => $validated['keterangan'] ?? null,
            'is_active' => true,
        ]);

        return redirect()->route('admin.rumah.penghuni.show', $id_rumah)
            ->with('success', 'Penghuni berhasil ditambahkan!');
    }

    /**
     * Hapus penghuni (soft delete = set is_active = false)
     */
    public function destroyPenghuni($id_penghuni)
    {
        try {
            $penghuni = Penghuni::findOrFail($id_penghuni);
            
            // Soft delete: set tanggal keluar dan is_active = false
            $penghuni->update([
                'is_active' => false,
                'tanggal_keluar' => now(),
            ]);

            return back()->with('success', 'Penghuni berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus penghuni: ' . $e->getMessage());
        }
    }

    /**
     * Hard delete penghuni (hapus permanen)
     */
    public function forceDeletePenghuni($id_penghuni)
    {
        try {
            $penghuni = Penghuni::findOrFail($id_penghuni);
            $penghuni->delete();
            return back()->with('success', 'Penghuni berhasil dihapus permanen!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus penghuni: ' . $e->getMessage());
        }
    }
}