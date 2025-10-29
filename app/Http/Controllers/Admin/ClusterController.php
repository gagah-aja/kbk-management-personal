<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cluster;
use App\Models\Rt;
use App\Models\Blok;
use App\Models\NamaCluster;

class ClusterController extends Controller
{
    /**
     * Tampilkan semua data cluster
     */
    public function index()
    {
        $clusters = Cluster::with(['rt', 'blok', 'namaCluster'])->latest()->get();
        return view('admin.cluster.index', compact('clusters'));
    }

    /**
     * Tampilkan form tambah data cluster
     */
    public function create()
    {
        $rts = Rt::all();
        $bloks = Blok::all();
        $namaClusters = NamaCluster::all();

        return view('admin.cluster.create', compact('rts', 'bloks', 'namaClusters'));
    }

    /**
     * Simpan data cluster baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_nama_cluster' => 'required|string|unique:cluster,id_nama_cluster',
            'id_rt' => 'required|exists:rt,id',
            'id_blok' => 'required|exists:blok,id',
        ]);

        Cluster::create([
            'id_nama_cluster' => $request->id_nama_cluster,
            'id_rt' => $request->id_rt,
            'id_blok' => $request->id_blok,
        ]);

        return redirect()->route('cluster.index')->with('success', 'Cluster berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail cluster
     */
    public function show($id)
    {
        $cluster = Cluster::with(['rt', 'blok', 'namaCluster'])->findOrFail($id);
        return view('admin.cluster.show', compact('cluster'));
    }

    /**
     * Tampilkan form edit cluster
     */
    public function edit($id)
    {
        $cluster = Cluster::findOrFail($id);
        $rts = Rt::all();
        $bloks = Blok::all();
        $namaClusters = NamaCluster::all();

        return view('admin.cluster.edit', compact('cluster', 'rts', 'bloks', 'namaClusters'));
    }

    /**
     * Update data cluster
     */
    public function update(Request $request, $id)
    {
        $cluster = Cluster::findOrFail($id);

        $request->validate([
            'id_nama_cluster' => 'required|string|unique:cluster,id_nama_cluster,' . $id,
            'id_rt' => 'required|exists:rt,id',
            'id_blok' => 'required|exists:blok,id',
        ]);

        $cluster->update([
            'id_nama_cluster' => $request->id_nama_cluster,
            'id_rt' => $request->id_rt,
            'id_blok' => $request->id_blok,
        ]);

        return redirect()->route('cluster.index')->with('success', 'Cluster berhasil diperbarui.');
    }

    /**
     * Hapus data cluster
     */
    public function destroy($id)
    {
        $cluster = Cluster::findOrFail($id);
        $cluster->delete();

        return redirect()->route('cluster.index')->with('success', 'Cluster berhasil dihapus.');
    }
}
