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
     * Tampilkan halaman dashboard admin
     */
    public function index()
    {
        // Total Rumah
        $totalRumah = Rumah::count();

        // Total Warga
        $totalWarga = Warga::count();

        // Total RT & RW
        $totalRt = Rt::count();
        $totalRw = Rw::count();

        // Total Cluster
        $totalCluster = Cluster::count();

        return view('pages.admin.dashboard.index', [
            'totalRumah' => $totalRumah,
            'totalWarga' => $totalWarga,
            'totalRt' => $totalRt,
            'totalRw' => $totalRw,
            'totalCluster' => $totalCluster,
        ]);
    }
}