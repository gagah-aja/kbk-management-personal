<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penghuni;
use App\Models\Warga;
use App\Models\Rumah;
use App\Models\Cluster;

class SearchController extends Controller
{
    /**
     * Tampilkan halaman pencarian
     */
    public function index()
    {
        return view('pages.user.search');
    }

    /**
     * API untuk live search
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (empty($query)) {
            return response()->json([]);
        }

        // Cari penghuni aktif berdasarkan nama warga
        $results = Penghuni::with([
            'warga',
            'rumah.cluster.namaCluster',
            'rumah.cluster.blok',
            'rumah.cluster.rt'
        ])
        ->whereHas('warga', function($q) use ($query) {
            $q->where('nama_lengkap', 'LIKE', '%' . $query . '%');
        })
        ->where('is_active', true)
        ->limit(20)
        ->get()
        ->map(function($penghuni) {
            return [
                'id' => $penghuni->id,
                'nama_warga' => $penghuni->warga->nama_lengkap ?? '-',
                'nik' => $penghuni->warga->nik ?? '-',
                'foto' => $penghuni->warga->foto ? asset('storage/' . $penghuni->warga->foto) : asset('image/default-avatar.png'),
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
     * Detail penghuni
     */
    public function detail($id)
    {
        $penghuni = Penghuni::with([
            'warga',
            'rumah.cluster.namaCluster',
            'rumah.cluster.blok',
            'rumah.cluster.rt'
        ])->findOrFail($id);

        return response()->json([
            'nama_warga' => $penghuni->warga->nama_lengkap ?? '-',
            'nik' => $penghuni->warga->nik ?? '-',
            'foto' => $penghuni->warga->foto ? asset('storage/' . $penghuni->warga->foto) : asset('image/default-avatar.png'),
            'foto_ktp' => $penghuni->warga->foto_ktp ? asset('storage/' . $penghuni->warga->foto_ktp) : null,
            'jenis_kelamin' => $penghuni->warga->jenis_kelamin ?? '-',
            'tanggal_lahir' => $penghuni->warga->tanggal_lahir ?? '-',
            'agama' => $penghuni->warga->agama ?? '-',
            'pekerjaan' => $penghuni->warga->pekerjaan ?? '-',
            'pendidikan' => $penghuni->warga->pendidikan_terakhir ?? '-',
            'status_penghuni' => $penghuni->status_penghuni,
            'tipe_penghuni' => $penghuni->tipe_penghuni,
            'tanggal_masuk' => $penghuni->tanggal_masuk ? $penghuni->tanggal_masuk->format('d-m-Y') : '-',
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