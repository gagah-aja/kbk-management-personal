<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penghuni;

class SearchController extends Controller
{
    public function index()
    {
        return view('pages.user.search');
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        if (empty($query)) {
            return response()->json([]);
        }

        $results = Penghuni::with([
            'warga',
            'rumah',
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

            /**
             * =============================================
             * FOTO RUMAH (Perbaikan Full)
             * =============================================
             * Foto rumah HARUS ada di:
             *   storage/app/public/rumah/
             * setelah "php artisan storage:link" → public/storage/rumah/
             */

            $fotoRumah = 'images/default-house.jpg'; // default
            // dd($penghuni->warga->foto);

            if (!empty($penghuni->rumah->gambar)) {
                $storagePath = 'storage/' . $penghuni->rumah->gambar;

                // Cek apakah file benar-benar ada
                if (file_exists(public_path($storagePath))) {
                    $fotoRumah = $storagePath;
                }
            }

            /**
             * FOTO WARGA
             */
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
        // dd($results);
        return response()->json($results);
    }

    public function detail($id)
    {
        $penghuni = Penghuni::with([
            'warga',
            'rumah',
            'rumah.cluster.namaCluster',
            'rumah.cluster.blok',
            'rumah.cluster.rt'
        ])->findOrFail($id);

        /**
         * FOTO WARGA (PERBAIKAN)
         */
        $fotoWarga = 'image/default-avatar.png';
        if (!empty($penghuni->warga->foto)) {
            $pathFotoWarga = 'storage/' . $penghuni->warga->foto;

            if (file_exists(public_path($pathFotoWarga))) {
                $fotoWarga = $pathFotoWarga;
            }
        }

        /**
         * FOTO KTP
         */
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
