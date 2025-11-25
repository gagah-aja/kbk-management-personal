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
    // =========================
    // 🔹 Statistik
    // =========================
    $total_warga   = Warga::count();
    $total_cluster = Cluster::count();
    $total_rt      = Rt::count();
    $total_rw      = Rw::count();

    // =========================
    // 🔹 Ambil Ketua RW & RT
    // =========================
    $ketua_rw_list = Rw::with('warga')->orderBy('nomor_rw', 'asc')->get();
    $ketua_rt_list = Rt::with('warga')->orderBy('nomor_rt', 'asc')->get();

    // =========================
    // 🔹 Ambil data landing page jika ada
    // =========================
    $landingPage = Setting::where('key', 'landing_page')->first();

    // =========================
    // 🔹 Kirim data ke view
    // =========================
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

    public function allKetuaRW()
{
    // Ambil semua RW beserta relasi warga (ketua RW)
    $ketua_rw_list = Rw::with('warga')->get();

    // Tampilkan view
    return view('pages.user.all_rw', compact('ketua_rw_list'));
}

public function allKetuaRT()
{
    $ketua_rt_list = Rt::with('warga')->orderBy('nomor_rt')->get();
    return view('pages.user.all_rt', compact('ketua_rt_list'));
}

}
