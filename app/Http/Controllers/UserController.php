<?php

namespace App\Http\Controllers;

use App\Models\Cluster;
use App\Models\Rt;
use App\Models\Rw;
use App\Models\Warga;
use App\Models\setting;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $total_warga = Warga::count();
        $total_cluster = Cluster::count();
        $total_rt = Rt::count();
           // Ambil data ketua RW dan ketua RT dari database
        $ketua_rw = Rw::with('warga')->first(); // ambil rw pertama (atau bisa pakai where jika mau RW tertentu)
        $ketua_rt = Rt::with('warga')->get(); // ambil rt pertama
        $landingPage = Setting::where('key', 'landing_page')->first();
        return view('pages.user.dashboard',compact('total_warga','total_cluster','total_rt','ketua_rw','ketua_rt','landingPage'));
    }
}
