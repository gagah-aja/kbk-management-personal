<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penghuni;
use App\Models\NamaCluster;
use App\Models\Cluster;
use App\Models\Blok;
use App\Models\Rumah;

class SearchController extends Controller
{
    public function index()
    {
        return view('pages.user.search');
    }

    /**
     * 🔍 API Search dengan Filter
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        $clusterId = $request->input('cluster');
        $blokId = $request->input('blok');
        $rumahId = $request->input('rumah');

        $results = Penghuni::with([
            'warga',
            'rumah',
            'rumah.cluster.namaCluster',
            'rumah.cluster.blok',
            'rumah.cluster.rt'
        ])
            ->where('is_active', true);

        // Filter berdasarkan nama warga
        if (!empty($query)) {
            $results->whereHas('warga', function ($q) use ($query) {
                $q->where('nama_lengkap', 'LIKE', '%' . $query . '%');
            });
        }

        // ✅ FIX: Filter berdasarkan cluster (by nama cluster, bukan id)
        if (!empty($clusterId)) {
            // Ambil nama cluster dari cluster yang dipilih
            $selectedCluster = Cluster::with('namaCluster')->find($clusterId);

            if ($selectedCluster && $selectedCluster->namaCluster) {
                $namaClusterId = $selectedCluster->id_nama_cluster;

                // Cari semua cluster ID dengan nama yang sama
                $clusterIds = Cluster::where('id_nama_cluster', $namaClusterId)
                    ->pluck('id')
                    ->toArray();

                // Filter rumah yang ada di cluster-cluster tersebut
                $results->whereHas('rumah', function ($q) use ($clusterIds) {
                    $q->whereIn('id_cluster', $clusterIds);
                });
            }
        }

        // ✅ FIX: Filter berdasarkan blok (cari cluster dengan nama & blok yang sama)
        if (!empty($blokId)) {
            if (!empty($clusterId)) {
                $selectedCluster = Cluster::with('namaCluster')->find($clusterId);

                if ($selectedCluster && $selectedCluster->namaCluster) {
                    $namaClusterId = $selectedCluster->id_nama_cluster;

                    // Cari semua cluster ID dengan nama cluster DAN blok yang sama
                    $clusterIds = Cluster::where('id_nama_cluster', $namaClusterId)
                        ->where('id_blok', $blokId)
                        ->pluck('id')
                        ->toArray();

                    $results->whereHas('rumah', function ($q) use ($clusterIds) {
                        $q->whereIn('id_cluster', $clusterIds);
                    });
                }
            } else {
                // Jika cluster tidak dipilih, filter hanya berdasarkan blok
                $results->whereHas('rumah.cluster', function ($q) use ($blokId) {
                    $q->where('id_blok', $blokId);
                });
            }
        }

        // Filter berdasarkan rumah
        if (!empty($rumahId)) {
            $results->where('id_rumah', $rumahId);
        }

        $results = $results->limit(50)->get()->map(function ($penghuni) {
            $fotoRumah = 'images/default-house.jpg';
            if (!empty($penghuni->rumah->gambar)) {
                $storagePath = 'storage/' . $penghuni->rumah->gambar;
                if (file_exists(public_path($storagePath))) {
                    $fotoRumah = $storagePath;
                }
            }

            $fotoWarga = 'image/default-avatar.png';
            if (!empty($penghuni->warga->foto)) {
                $pathFotoWarga = 'storage/' . $penghuni->warga->foto;
                if (file_exists(public_path($pathFotoWarga))) {
                    $fotoWarga = $pathFotoWarga;
                }
            }

            return [
                'id' => $penghuni->id,
                'nama_warga' => $penghuni->warga->nama_lengkap ?? '-',
                'nik' => $penghuni->warga->nik ?? '-',
                'foto' => asset($fotoWarga),
                'foto_rumah' => asset($fotoRumah),
                'status_penghuni' => $penghuni->status_penghuni,
                'tipe_penghuni' => $penghuni->tipe_penghuni,
                'alamat' => $penghuni->rumah->alamat_lengkap ?? '-',
                'nomor_rumah' => $penghuni->rumah->nomor_rumah ?? '-',
                'cluster' => $penghuni->rumah->cluster->namaCluster->nama_cluster ?? '-',
                'blok' => $penghuni->rumah->cluster->blok->nama_blok ?? '-',
                'rt' => $penghuni->rumah->cluster->rt->nomor_rt ?? '-',
                'no_telp' => $penghuni->warga->no_telp ?? '-',
                'email' => $penghuni->warga->email ?? '-',
            ];
        });

        return response()->json($results);
    }

    /**
     * 🔍 API: Get All Clusters
     */
    public function getClusters()
    {
        $clusters = Cluster::with('namaCluster')
            ->select('id', 'id_nama_cluster')
            ->distinct()
            ->get()
            ->map(function ($cluster) {
                return [
                    'id' => $cluster->id,
                    'nama' => $cluster->namaCluster->nama_cluster ?? 'Unknown'
                ];
            })
            ->unique('nama')
            ->values();

        return response()->json($clusters);
    }

    /**
     * 🧱 API: Get Blok by Cluster
     * Ambil semua blok unik berdasarkan nama cluster
     */
    public function getBlokByCluster($clusterId)
    {
        // 1. Cari cluster yang dipilih untuk dapat nama cluster-nya
        $selectedCluster = Cluster::with('namaCluster')->find($clusterId);

        if (!$selectedCluster || !$selectedCluster->namaCluster) {
            return response()->json([]);
        }

        // 2. Cari semua cluster dengan nama cluster yang sama
        $clusters = Cluster::where('id_nama_cluster', $selectedCluster->id_nama_cluster)
            ->with('blok')
            ->get();

        // 3. Ambil semua blok unik
        $bloks = $clusters
            ->map(function ($cluster) {
                if ($cluster->blok) {
                    return [
                        'id' => $cluster->blok->id,
                        'nama' => $cluster->blok->nama_blok,
                        'cluster_id' => $cluster->id
                    ];
                }
                return null;
            })
            ->filter() // Hapus null
            ->unique('id') // Hapus duplikat berdasarkan id blok
            ->sortBy('nama') // Sort by nama blok
            ->values() // Reset array keys
            ->toArray();

        return response()->json($bloks);
    }

    /**
     * 🏠 API: Get Rumah by Cluster & Blok
     */
    public function getRumahByFilter(Request $request)
    {
        $clusterId = $request->input('cluster');
        $blokId = $request->input('blok');

        // 1. Cari cluster IDs yang sesuai
        $clusterIds = [];

        if ($clusterId) {
            $selectedCluster = Cluster::with('namaCluster')->find($clusterId);

            if ($selectedCluster && $selectedCluster->namaCluster) {
                // Ambil semua cluster dengan nama yang sama
                $clusterIds = Cluster::where('id_nama_cluster', $selectedCluster->id_nama_cluster)
                    ->when($blokId, function ($q) use ($blokId) {
                        return $q->where('id_blok', $blokId);
                    })
                    ->pluck('id')
                    ->toArray();
            }
        }

        // 2. Query rumah
        $query = Rumah::query();

        if (!empty($clusterIds)) {
            $query->whereIn('id_cluster', $clusterIds);
        } elseif ($clusterId) {
            $query->where('id_cluster', $clusterId);
        }

        $rumah = $query->select('id', 'nomor_rumah', 'alamat_lengkap')
            ->orderBy('nomor_rumah')
            ->get()
            ->map(function ($r) {
                return [
                    'id' => $r->id,
                    'nomor' => $r->nomor_rumah,
                    'alamat' => $r->alamat_lengkap
                ];
            });

        return response()->json($rumah);
    }

    /**
     * 👤 Detail Penghuni
     */
    public function detail($id)
    {
        $penghuni = Penghuni::with([
            'warga',
            'rumah',
            'rumah.cluster.namaCluster',
            'rumah.cluster.blok',
            'rumah.cluster.rt'
        ])->findOrFail($id);

        $fotoWarga = 'image/default-avatar.png';
        if (!empty($penghuni->warga->foto)) {
            $pathFotoWarga = 'storage/' . $penghuni->warga->foto;
            if (file_exists(public_path($pathFotoWarga))) {
                $fotoWarga = $pathFotoWarga;
            }
        }

        $fotoKtp = null;
        if (!empty($penghuni->warga->foto_ktp)) {
            $pathFotoKtp = 'storage/' . $penghuni->warga->foto_ktp;
            if (file_exists(public_path($pathFotoKtp))) {
                $fotoKtp = asset($pathFotoKtp);
            }
        }

        return response()->json([
            'nama_warga' => $penghuni->warga->nama_lengkap ?? '-',
            'nik' => $penghuni->warga->nik ?? '-',
            'foto' => asset($fotoWarga),
            'foto_ktp' => $fotoKtp,
            'jenis_kelamin' => $penghuni->warga->jenis_kelamin ?? '-',
            'tanggal_lahir' => $penghuni->warga->tanggal_lahir ?? '-',
            'agama' => $penghuni->warga->agama ?? '-',
            'pekerjaan' => $penghuni->warga->pekerjaan ?? '-',
            'pendidikan' => $penghuni->warga->pendidikan_terakhir ?? '-',
            'status_penghuni' => $penghuni->status_penghuni,
            'tipe_penghuni' => $penghuni->tipe_penghuni,
            'tanggal_masuk' => $penghuni->tanggal_masuk
                ? $penghuni->tanggal_masuk->format('d-m-Y')
                : '-',
            'alamat' => $penghuni->rumah->alamat_lengkap ?? '-',
            'nomor_rumah' => $penghuni->rumah->nomor_rumah ?? '-',
            'cluster' => $penghuni->rumah->cluster->namaCluster->nama_cluster ?? '-',
            'blok' => $penghuni->rumah->cluster->blok->nama_blok ?? '-',
            'rt' => $penghuni->rumah->cluster->rt->nomor_rt ?? '-',
            'no_telp' => $penghuni->warga->no_telp ?? '-',
            'email' => $penghuni->warga->email ?? '-',
        ]);
    }
}
