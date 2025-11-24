<?php

namespace App\Http\Controllers;

use App\Models\Cluster;
use App\Models\Rt;
use App\Models\Rw;
use App\Models\Warga;
use App\Models\Setting;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Total Warga, Cluster, RT
        $total_warga = Warga::count();
        $total_cluster = Cluster::count();
        $total_rt = Rt::count();
        $total_rw = Rw::count(); // kalau mau total RW juga ditampilkan

        // Ambil semua Ketua RW & Ketua RT
        $ketua_rw_list = Rw::with('warga')->orderBy('nomor_rw', 'asc')->get();
        $ketua_rt_list = Rt::with('warga')->orderBy('nomor_rt', 'asc')->get();

        // Ambil data landing page jika ada
        $landingPage = Setting::where('key', 'landing_page')->first();

        return view('pages.user.dashboard', compact(
            'total_warga',
            'total_cluster',
            'total_rt',
            'total_rw',
            'ketua_rw_list',
            'ketua_rt_list',
            'landingPage'
        ));
    }
}
