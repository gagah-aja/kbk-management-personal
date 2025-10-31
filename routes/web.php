<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ClusterController;
use App\Http\Controllers\Admin\RtController;
use App\Http\Controllers\Admin\RwController;
use App\Http\Controllers\Admin\BlokController;
use App\Http\Controllers\Admin\NamaClusterController;
use App\Http\Controllers\Admin\WargaController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di file ini kita mendefinisikan semua route web aplikasi.
| Termasuk halaman depan dan seluruh route untuk halaman admin.
|
*/

// Rute untuk pengguna yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

});

// Rute yang tidak memerlukan login (atau rute "guest")
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/auth_login', [AuthController::class, 'authenticate'])->name('auth_login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');




// =====================================================
// 🔹 ROUTE UNTUK ADMIN PANEL
// =====================================================
Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // // Manajemen Cluster
    // Route::resource('cluster', ClusterController::class);

    // 🔹 Data RT
    Route::get('/data-rt', [RtController::class, 'index'])->name('data-rt.index');
    Route::post('/data-rt', [RtController::class, 'store'])->name('data-rt.store');
    Route::put('/data-rt/{id}', [RtController::class, 'update'])->name('data-rt.update');
    Route::delete('/data-rt/{id}', [RtController::class, 'destroy'])->name('data-rt.destroy');

    Route::get('/data-rw', [RwController::class, 'index'])->name('rw.index');
    Route::post('/data-rw', [RwController::class, 'store'])->name('rw.store');
    Route::post('/data-rw/{id}', [RwController::class, 'update'])->name('rw.update');
    Route::delete('/admin/data-rw/{id}', [RwController::class, 'destroy'])->name('rw.destroy');

    // 🧱 Manajemen Blok
    // =====================================================
    Route::get('/nama-blok', [BlokController::class, 'index'])->name('blok.index');
    Route::post('/nama-blok', [BlokController::class, 'store'])->name('blok.store');
    Route::put('/nama-blok/{id}', [BlokController::class, 'update'])->name('blok.update');
    Route::delete('/nama-blok/{id}', [BlokController::class, 'destroy'])->name('blok.destroy');

    // Manajemen Nama Cluster
    Route::resource('nama_cluster', NamaClusterController::class);


    Route::get('/warga', [WargaController::class, 'index'])->name('warga.index');
    Route::get('/warga/tambah/halaman', [WargaController::class, 'tambah_halaman'])->name('warga.tambah.halaman');
    Route::get('/warga/edit/halaman/{id}', [WargaController::class, 'edit_halaman'])->name('warga.edit.halaman');
    Route::post('/warga/tambah', [WargaController::class, 'tambah'])->name('warga.tambah');
    Route::post('/warga/hapus/{id}', [WargaController::class, 'hapus'])->name('warga.hapus');
    Route::post('/warga/update/{id}', [WargaController::class, 'update'])->name('warga.update');

    Route::get('/nama-cluster', [NamaClusterController::class, 'index'])->name('nama-cluster.index');
    Route::get('/nama-cluster/create', [NamaClusterController::class, 'create'])->name('nama-cluster.create');
    Route::post('/nama-cluster', [NamaClusterController::class, 'store'])->name('nama-cluster.store');
    Route::get('/nama-cluster/{id}', [NamaClusterController::class, 'show'])->name('nama-cluster.show');
    Route::get('/nama-cluster/{id}/edit', [NamaClusterController::class, 'edit'])->name('nama-cluster.edit');
    Route::put('/nama-cluster/{id}', [NamaClusterController::class, 'update'])->name('nama-cluster.update');
    Route::delete('/nama-cluster/{id}', [NamaClusterController::class, 'destroy'])->name('nama-cluster.destroy');
});
