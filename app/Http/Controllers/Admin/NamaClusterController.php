<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NamaCluster;
use Illuminate\Support\Facades\DB;

class NamaClusterController extends Controller
{
    /**
     * Tampilkan semua data Nama Cluster (dengan pagination & search)
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $namaClusters = NamaCluster::query()
            ->when($search, function ($query, $search) {
                $query->where('nama_cluster', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        $namaClusters->appends(['search' => $search]);

        return view('pages.admin.nama-cluster.index', compact('namaClusters', 'search'));
    }

    /**
     * Tampilkan form tambah Nama Cluster
     */
    public function create()
    {
        return view('pages.admin.nama-cluster.create');
    }

    /**
     * Simpan Nama Cluster baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_cluster' => 'required|string|max:100|unique:nama_cluster,nama_cluster',
        ], [
            'nama_cluster.required' => 'Nama cluster wajib diisi.',
            'nama_cluster.unique' => 'Nama cluster sudah terdaftar.',
        ]);

        NamaCluster::create([
            'nama_cluster' => $request->nama_cluster,
        ]);

        return redirect()->route('admin.nama-cluster.index')
            ->with('success', 'Nama cluster berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit Nama Cluster
     */
    public function edit($id)
    {
        $namaCluster = NamaCluster::findOrFail($id);
        return view('pages.admin.nama-cluster.edit', compact('namaCluster'));
    }

    /**
     * Update Nama Cluster di database
     */
    public function update(Request $request, $id)
    {
        $namaCluster = NamaCluster::findOrFail($id);

        $request->validate([
            'nama_cluster' => 'required|string|max:100|unique:nama_cluster,nama_cluster,' . $id,
        ], [
            'nama_cluster.required' => 'Nama cluster wajib diisi.',
            'nama_cluster.unique' => 'Nama cluster sudah terdaftar.',
        ]);

        $namaCluster->update([
            'nama_cluster' => $request->nama_cluster,
        ]);

        return redirect()->route('admin.nama-cluster.index')
            ->with('success', 'Nama cluster berhasil diperbarui.');
    }

    /**
     * Hapus Nama Cluster dari database
     */
    public function destroy($id)
{
    try {
        $namaCluster = NamaCluster::findOrFail($id);

        // Cek apakah nama cluster sedang digunakan
        if ($namaCluster->cluster()->count() > 0) {
            return redirect()->route('admin.nama-cluster.index')->with([
                'error' => 'Nama cluster tidak dapat dihapus karena masih digunakan.',
                'clusterId' => $namaCluster->id, // penting agar tombol Cek Cluster muncul
            ]);
        }

        $namaCluster->delete();

        // Reset auto increment jika tabel kosong
        if (NamaCluster::count() === 0) {
            DB::statement('ALTER TABLE nama_cluster AUTO_INCREMENT = 1;');
        }

        return redirect()->route('admin.nama-cluster.index')
            ->with('success', 'Nama cluster berhasil dihapus.');
    } catch (\Exception $e) {
        return redirect()->route('admin.nama-cluster.index')->with([
            'error' => 'Gagal menghapus nama cluster: ' . $e->getMessage(),
            'clusterId' => $id, // tetap kirim clusterId agar tombol muncul
        ]);
    }
}


}