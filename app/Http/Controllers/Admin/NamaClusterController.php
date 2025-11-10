<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NamaCluster;

class NamaClusterController extends Controller
{
    /**
     * Tampilkan semua data Nama Cluster
     */
    public function index()
    {
        $namaClusters = NamaCluster::orderBy('id', 'asc')->get();
        return view('pages.admin.nama-cluster.index', compact('namaClusters'));
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
    // Hapus method getNextId() dan custom ID
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
            ->with('success', 'Cluster berhasil ditambahkan!');
    }

    /**
     * Hitung ID terkecil yang belum dipakai
     */
    private function getNextId()
    {
        $usedIds = NamaCluster::pluck('id')->toArray();
        $newId = 1;
        while (in_array($newId, $usedIds)) {
            $newId++;
        }
        return $newId;
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
    // Hapus validasi dan update custom ID di method update
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
            ->with('success', 'Nama Cluster berhasil diperbarui.');
    }

    /**
     * Hapus Nama Cluster dari database
     */
    public function destroy($id)
    {
        try {
            $namaCluster = NamaCluster::findOrFail($id);
            $namaCluster->delete();

            return redirect()->route('admin.nama-cluster.index')
                ->with('success', 'Nama Cluster berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.nama-cluster.index')
                ->with('error', 'Gagal menghapus nama cluster: ' . $e->getMessage());
        }
    }
}
