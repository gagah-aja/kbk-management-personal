<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ClusterController;
use App\Http\Controllers\Admin\RumahController;
use App\Http\Controllers\Admin\RtController;
use App\Http\Controllers\Admin\RwController;
use App\Http\Controllers\Admin\NamaClusterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di file ini kita mendefinisikan semua route web aplikasi.
| Termasuk halaman depan dan seluruh route untuk halaman admin.
|
*/

// Rute untuk menampilkan formulir login
Route::get('/', [AuthController::class, 'login'])->name('login');

// Rute untuk memproses data login (POST)
Route::post('/auth_login', [AuthController::class, 'authenticate'])->name('auth_login');

// Rute untuk logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =====================================================
// 🔹 ROUTE UNTUK ADMIN PANEL
// =====================================================
Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Cluster
    Route::resource('cluster', ClusterController::class);

    // Manajemen Rumah
    Route::resource('rumah', RumahController::class);

    // Manajemen RT
    Route::resource('rt', RtController::class);

    // Manajemen RW
    Route::resource('rw', RwController::class);

    // Manajemen Nama Cluster
    Route::resource('nama_cluster', NamaClusterController::class);
});
