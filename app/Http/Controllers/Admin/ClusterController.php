<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cluster;
use App\Models\NamaCluster;
use App\Models\Rt;
use App\Models\Blok;
use Illuminate\Support\Facades\DB;

class ClusterController extends Controller
{
    // 🟢 Tampilkan semua data Cluster
    public function index()
    {
        $clusters = Cluster::with(['namaCluster', 'rt', 'blok'])->get();
        $nama_clusters = NamaCluster::all();
        $rts = Rt::all();
        $bloks = Blok::all();

        return view('pages.admin.data-cluster', compact('clusters', 'nama_clusters', 'rts', 'bloks'));
    }

    // 🟢 Simpan Data Baru
    public function store(Request $request)
    {
        $request->validate([
            'id_nama_cluster' => 'required|exists:nama_cluster,id',
            'id_rt' => 'required|exists:rt,id',
            'id_blok' => 'required|exists:blok,id',
        ]);

        // 🔎 Cek kombinasi sudah ada
        $exists = Cluster::where('id_nama_cluster', $request->id_nama_cluster)
                        ->where('id_rt', $request->id_rt)
                        ->where('id_blok', $request->id_blok)
                        ->first();

        if ($exists) {
            return redirect()->back()->with('info', 'Cluster dengan kombinasi ini sudah ada.');
        }

        Cluster::create([
            'id_nama_cluster' => $request->id_nama_cluster,
            'id_rt' => $request->id_rt,
            'id_blok' => $request->id_blok,
        ]);

        return redirect()->route('admin.data-cluster.index')
            ->with('success', 'Cluster berhasil ditambahkan.');
    }

    // 🟡 Tampilkan data untuk diedit (AJAX)
    public function edit($id)
    {
        $cluster = Cluster::findOrFail($id);
        return response()->json($cluster);
    }

    // 🟠 Update Data Cluster
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_nama_cluster' => 'required|exists:nama_cluster,id',
            'id_rt' => 'required|exists:rt,id',
            'id_blok' => 'required|exists:blok,id',
        ]);

        $cluster = Cluster::findOrFail($id);

        // 🔎 Cek kombinasi unik saat update
        $exists = Cluster::where('id_nama_cluster', $request->id_nama_cluster)
                        ->where('id_rt', $request->id_rt)
                        ->where('id_blok', $request->id_blok)
                        ->where('id', '<>', $id)
                        ->first();

        if ($exists) {
            return redirect()->back()->with('info', 'Cluster dengan kombinasi ini sudah ada.');
        }

        $cluster->update([
            'id_nama_cluster' => $request->id_nama_cluster,
            'id_rt' => $request->id_rt,
            'id_blok' => $request->id_blok,
        ]);

        return redirect()->route('admin.data-cluster.index')
            ->with('success', 'Data cluster berhasil diperbarui.');
    }

    // 🔴 Hapus Data Cluster
    public function destroy($id)
    {
        $cluster = Cluster::findOrFail($id);
        $cluster->delete();

        // 🔁 Reset auto increment jika tabel kosong
        if (Cluster::count() === 0) {
            DB::statement('ALTER TABLE cluster AUTO_INCREMENT = 1;');
        }

        return redirect()->route('admin.data-cluster.index')
            ->with('success', 'Cluster berhasil dihapus.');
    }
}
