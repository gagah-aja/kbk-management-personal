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
        return view('pages.admin.nama-cluster', compact('namaClusters'));
    }

    /**
     * Tampilkan form tambah Nama Cluster
     */
    public function create()
    {
        return view('admin.nama-cluster.create');
    }

    /**
     * Simpan Nama Cluster baru ke database
     */
    public function store(Request $request)
{
    // Ambil semua ID yang sudah ada
    $usedIds = \App\Models\NamaCluster::pluck('id')->toArray();

    // Cari ID terkecil yang belum digunakan (mulai dari 1)
    $newId = 1;
    while (in_array($newId, $usedIds)) {
        $newId++;
    }

    // Kalau user isi ID manual, pakai itu, kalau tidak, pakai $newId
    $id = $request->id ?: $newId;

    // Simpan data baru
    \App\Models\NamaCluster::create([
        'id' => $id,
        'nama_cluster' => $request->nama_cluster,
    ]);

    return redirect()->back()->with('success', 'Cluster berhasil ditambahkan!');
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
