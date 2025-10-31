<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warga;
use App\Models\Rumah;
use App\Models\Cluster;
use App\Models\Rt;
use App\Models\Rw;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard admin.
     */
 public function index()
    {
        // 1. Total Rumah
        $totalRumah = Rumah::count();

        // 2. Total Warga
        $totalWarga = Warga::count();

        // 3. Total RT & RW
        $totalRt = Rt::count();
        $totalRw = Rw::count();

        // 4. Total Cluster
        $totalCluster = Cluster::count();

        // Kirim semua data ke view
        return view('pages.admin.dashboard', [
            'totalRumah' => $totalRumah,
            'totalWarga' => $totalWarga,
            'totalRt' => $totalRt,
            'totalRw' => $totalRw,
            'totalCluster' => $totalCluster,
        ]);
    }
}
