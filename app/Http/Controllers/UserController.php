<?php

namespace App\Http\Controllers;

use App\Models\Cluster;
use App\Models\Rt;
use App\Models\Warga;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $total_warga = Warga::count();
        $total_cluster = Cluster::count();
        $total_rt = Rt::count();
        return view('pages.user.dashboard',compact('total_warga','total_cluster','total_rt'));
    }
}
