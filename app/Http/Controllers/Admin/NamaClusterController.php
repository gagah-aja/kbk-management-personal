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
        $namaClusters = NamaCluster::latest()->get();
        return view('pages.admin.nama_cluster', compact('namaClusters'));
    }

    /**
     * Tampilkan form tambah Nama Cluster
     */
    public function create()
    {
        return view('admin.nama_cluster.create');
    }

    /**
     * Simpan Nama Cluster baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'nullable|integer|unique:nama_cluster,id',
            'nama_cluster' => 'required|string|max:100|unique:nama_cluster,nama_cluster',
        ]);

        // Jika ID dikirim manual, pakai. Kalau tidak, biarkan auto increment.
        NamaCluster::create([
            'id' => $request->id,
            'nama_cluster' => $request->nama_cluster,
        ]);

        return redirect()->route('admin.nama-cluster.index')->with('success', 'Nama Cluster berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail Nama Cluster
     */
    public function show($id)
    {
        $namaCluster = NamaCluster::findOrFail($id);
        return view('admin.nama_cluster.show', compact('namaCluster'));
    }

    /**
     * Tampilkan form edit Nama Cluster
     */
    public function edit($id)
    {
        $namaCluster = NamaCluster::findOrFail($id);
        return view('admin.nama_cluster.edit', compact('namaCluster'));
    }

    /**
     * Update Nama Cluster di database
     */
    public function update(Request $request, $id)
    {
        $namaCluster = NamaCluster::findOrFail($id);

        $request->validate([
            'id' => 'nullable|integer|unique:nama_cluster,id,' . $id,
            'nama_cluster' => 'required|string|max:100|unique:nama_cluster,nama_cluster,' . $id,
        ]);

        $namaCluster->update([
            'id' => $request->id ?? $namaCluster->id,
            'nama_cluster' => $request->nama_cluster,
        ]);

        return redirect()->route('admin.nama-cluster.index')->with('success', 'Nama Cluster berhasil diperbarui.');
    }

    /**
     * Hapus Nama Cluster dari database
     */
    public function destroy($id)
    {
        $namaCluster = NamaCluster::findOrFail($id);
        $namaCluster->delete();

        return redirect()->route('admin.nama-cluster.index')->with('success', 'Nama Cluster berhasil dihapus.');
    }
}
