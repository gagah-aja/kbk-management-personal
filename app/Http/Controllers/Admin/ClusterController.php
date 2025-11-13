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
    /**
     * Tampilkan semua data Cluster
     */
    public function index(Request $request)
{
    $search = $request->get('search');

    $clusters = Cluster::with(['namaCluster', 'rt', 'blok'])
        ->when($search, function ($query, $search) {
            $query->whereHas('namaCluster', function ($q) use ($search) {
                $q->where('nama_cluster', 'like', "%{$search}%");
            })
            ->orWhereHas('rt', function ($q) use ($search) {
                $q->where('nomor_rt', 'like', "%{$search}%");
            })
            ->orWhereHas('blok', function ($q) use ($search) {
                $q->where('nama_blok', 'like', "%{$search}%");
            });
        })
        ->orderBy('id', 'desc')
        ->paginate(1)
        ->appends(['search' => $search]); // biar query search tetap ada di pagination link

    return view('pages.admin.cluster.index', compact('clusters', 'search'));
}


    /**
     * Tampilkan form tambah cluster
     */
    public function create()
    {
        $nama_clusters = NamaCluster::all();
        $rts = Rt::all();
        $bloks = Blok::all();
        
        return view('pages.admin.cluster.create', compact('nama_clusters', 'rts', 'bloks'));
    }

    /**
     * Simpan Data Baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_nama_cluster' => 'required|exists:nama_cluster,id',
            'id_rt' => 'required|exists:rt,id',
            'id_blok' => 'required|exists:blok,id',
        ], [
            'id_nama_cluster.required' => 'Nama cluster wajib dipilih.',
            'id_nama_cluster.exists' => 'Nama cluster tidak valid.',
            'id_rt.required' => 'RT wajib dipilih.',
            'id_rt.exists' => 'RT tidak valid.',
            'id_blok.required' => 'Blok wajib dipilih.',
            'id_blok.exists' => 'Blok tidak valid.',
        ]);

        // Cek kombinasi sudah ada
        $exists = Cluster::where('id_nama_cluster', $request->id_nama_cluster)
                        ->where('id_rt', $request->id_rt)
                        ->where('id_blok', $request->id_blok)
                        ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('info', 'Cluster dengan kombinasi ini sudah ada.');
        }

        Cluster::create([
            'id_nama_cluster' => $request->id_nama_cluster,
            'id_rt' => $request->id_rt,
            'id_blok' => $request->id_blok,
        ]);

        return redirect()->route('admin.cluster.index')
            ->with('success', 'Cluster berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit
     */
    public function edit($id)
    {
        $cluster = Cluster::findOrFail($id);
        $nama_clusters = NamaCluster::all();
        $rts = Rt::all();
        $bloks = Blok::all();
        
        return view('pages.admin.cluster.edit', compact('cluster', 'nama_clusters', 'rts', 'bloks'));
    }

    /**
     * Update Data Cluster
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_nama_cluster' => 'required|exists:nama_cluster,id',
            'id_rt' => 'required|exists:rt,id',
            'id_blok' => 'required|exists:blok,id',
        ], [
            'id_nama_cluster.required' => 'Nama cluster wajib dipilih.',
            'id_nama_cluster.exists' => 'Nama cluster tidak valid.',
            'id_rt.required' => 'RT wajib dipilih.',
            'id_rt.exists' => 'RT tidak valid.',
            'id_blok.required' => 'Blok wajib dipilih.',
            'id_blok.exists' => 'Blok tidak valid.',
        ]);

        $cluster = Cluster::findOrFail($id);

        // Cek kombinasi unik saat update
        $exists = Cluster::where('id_nama_cluster', $request->id_nama_cluster)
                        ->where('id_rt', $request->id_rt)
                        ->where('id_blok', $request->id_blok)
                        ->where('id', '<>', $id)
                        ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('info', 'Cluster dengan kombinasi ini sudah ada.');
        }

        $cluster->update([
            'id_nama_cluster' => $request->id_nama_cluster,
            'id_rt' => $request->id_rt,
            'id_blok' => $request->id_blok,
        ]);

        return redirect()->route('admin.cluster.index')
            ->with('success', 'Data cluster berhasil diperbarui.');
    }

    /**
     * Hapus Data Cluster
     */
    public function destroy($id)
    {
        try {
            $cluster = Cluster::findOrFail($id);
            
            // Cek apakah cluster sedang digunakan oleh rumah
            if ($cluster->rumah()->count() > 0) {
                return redirect()->route('admin.cluster.index')
                    ->with('error', 'Cluster tidak dapat dihapus karena masih digunakan oleh rumah.');
            }
            
            $cluster->delete();
    
            // Reset auto increment jika tabel kosong
            if (Cluster::count() === 0) {
                DB::statement('ALTER TABLE cluster AUTO_INCREMENT = 1;');
            }
    
            return redirect()->route('admin.cluster.index')
                ->with('success', 'Cluster berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.cluster.index')
                ->with('error', 'Gagal menghapus cluster: ' . $e->getMessage());
        }
    }
}