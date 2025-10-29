<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warga;
use App\Models\Rumah;
use App\Models\Cluster;
use App\Models\Rt;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard admin.
     */
    public function index()
    {
        // Hitung data ringkasan
        $totalWarga   = Warga::count();
        $totalRumah   = Rumah::count();
        $totalCluster = Cluster::count();
        $totalRt      = Rt::count();

        // Kirim data ke view
        return view('admin.dashboard', compact(
            'totalWarga',
            'totalRumah',
            'totalCluster',
            'totalRt'
        ));
    }
}
