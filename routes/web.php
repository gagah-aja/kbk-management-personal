<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ClusterController;
use App\Http\Controllers\Admin\RtController;
use App\Http\Controllers\Admin\RwController;
use App\Http\Controllers\Admin\BlokController;
use App\Http\Controllers\Admin\NamaClusterController;
use App\Http\Controllers\Admin\RumahController;
use App\Http\Controllers\Admin\WargaController;
use App\Http\Controllers\Admin\StatusRumahController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di file ini kita mendefinisikan semua route web aplikasi.
| Termasuk halaman depan dan seluruh route untuk halaman admin.
|
*/

// =====================================================
// 🔹 ROUTE PUBLIC (Guest)
// =====================================================
Route::get('/', [UserController::class, 'index'])->name('dashboard');
    Route::get('/ketua-rw', [UserController::class, 'allKetuaRW'])->name('ketua-rw.all');
    Route::get('/ketua-rt', [UserController::class, 'allKetuaRT'])->name('rt.index');



// 🔍 Route Pencarian Warga/Penghuni
Route::get('/pencarian-warga', [App\Http\Controllers\SearchController::class, 'index'])->name('search.index');
Route::get('/api/search-warga', [App\Http\Controllers\SearchController::class, 'search'])->name('search.api');
Route::get('/api/detail-penghuni/{id}', [App\Http\Controllers\SearchController::class, 'detail'])->name('search.detail');

// Route untuk Filter Cascade
Route::get('/api/clusters', [App\Http\Controllers\SearchController::class, 'getClusters'])->name('search.clusters');
Route::get('/api/blok-by-cluster/{clusterId}', [App\Http\Controllers\SearchController::class, 'getBlokByCluster'])->name('search.blok');
Route::get('/api/rumah-by-filter', [App\Http\Controllers\SearchController::class, 'getRumahByFilter'])->name('search.rumah');

Route::prefix('user')->name('user.')->group(function () {
    // Tambahkan route user di sini jika ada
});

// =====================================================
// 🔹 ROUTE AUTHENTICATION
// =====================================================
Route::get('/admin/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/login', [AuthController::class, 'authenticate'])->name('auth_login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =====================================================
// 🔹 ROUTE ADMIN PANEL (Memerlukan Authentication)
// =====================================================
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    // =====================================================
    // 📊 Dashboard Admin
    // =====================================================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // =====================================================
    // 🏘️ Manajemen Cluster
    // =====================================================
    Route::get('/cluster', [ClusterController::class, 'index'])->name('cluster.index');
    Route::get('/cluster/create', [ClusterController::class, 'create'])->name('cluster.create');
    Route::post('/cluster', [ClusterController::class, 'store'])->name('cluster.store');
    Route::get('/cluster/{id}/edit', [ClusterController::class, 'edit'])->name('cluster.edit');
    Route::put('/cluster/{id}', [ClusterController::class, 'update'])->name('cluster.update');
    Route::delete('/cluster/{id}', [ClusterController::class, 'destroy'])->name('cluster.destroy');

    // =====================================================
    // 🏘️ Manajemen Nama Cluster
    // =====================================================
    Route::get('/nama-cluster', [NamaClusterController::class, 'index'])->name('nama-cluster.index');
    Route::get('/nama-cluster/create', [NamaClusterController::class, 'create'])->name('nama-cluster.create');
    Route::post('/nama-cluster', [NamaClusterController::class, 'store'])->name('nama-cluster.store');
    Route::get('/nama-cluster/{id}', [NamaClusterController::class, 'show'])->name('nama-cluster.show');
    Route::get('/nama-cluster/{id}/edit', [NamaClusterController::class, 'edit'])->name('nama-cluster.edit');
    Route::put('/nama-cluster/{id}', [NamaClusterController::class, 'update'])->name('nama-cluster.update');
    Route::delete('/nama-cluster/{id}', [NamaClusterController::class, 'destroy'])->name('nama-cluster.destroy');

    // =====================================================
    // 🧱 Manajemen Blok
    // =====================================================
    Route::get('/blok', [BlokController::class, 'index'])->name('blok.index');
    Route::get('/blok/create', [BlokController::class, 'create'])->name('blok.create');
    Route::post('/blok', [BlokController::class, 'store'])->name('blok.store');
    Route::get('/blok/{id}/edit', [BlokController::class, 'edit'])->name('blok.edit');
    Route::put('/blok/{id}', [BlokController::class, 'update'])->name('blok.update');
    Route::delete('/blok/{id}', [BlokController::class, 'destroy'])->name('blok.destroy');

    // =====================================================
    // 👥 Manajemen RW (Rukun Warga)
    // =====================================================
    Route::get('/rw', [RwController::class, 'index'])->name('rw.index');
    Route::get('/rw/create', [RwController::class, 'create'])->name('rw.create');
    Route::post('/rw', [RwController::class, 'store'])->name('rw.store');
    Route::get('/rw/{id}/edit', [RwController::class, 'edit'])->name('rw.edit');
    Route::put('/rw/{id}', [RwController::class, 'update'])->name('rw.update');
    Route::delete('/rw/{id}', [RwController::class, 'destroy'])->name('rw.destroy');

    // =====================================================
    // 👥 Manajemen RT (Rukun Tetangga)
    // =====================================================
    Route::get('/rt', [RtController::class, 'index'])->name('rt.index');
    Route::get('/rt/create', [RtController::class, 'create'])->name('rt.create');
    Route::post('/rt', [RtController::class, 'store'])->name('rt.store');
    Route::get('/rt/{id}/edit', [RtController::class, 'edit'])->name('rt.edit');
    Route::put('/rt/{id}', [RtController::class, 'update'])->name('rt.update');
    Route::delete('/rt/{id}', [RtController::class, 'destroy'])->name('rt.destroy');

    // =====================================================
    // 🏠 Manajemen Rumah
    // =====================================================
    Route::get('/rumah', [RumahController::class, 'index'])->name('rumah.index');
    Route::get('/rumah/create', [RumahController::class, 'create'])->name('rumah.create');
    Route::post('/rumah', [RumahController::class, 'store'])->name('rumah.store');
    Route::get('/rumah/{id}/edit', [RumahController::class, 'edit'])->name('rumah.edit');
    Route::put('/rumah/{id}', [RumahController::class, 'update'])->name('rumah.update');
    Route::delete('/rumah/{id}', [RumahController::class, 'destroy'])->name('rumah.destroy');

    // ⭐ Manajemen Penghuni
    // =====================================================
    Route::prefix('rumah/{id_rumah}/penghuni')->name('rumah.penghuni.')->group(function () {
        Route::get('/', [RumahController::class, 'showPenghuni'])->name('show'); // Halaman list penghuni
        Route::get('/create', [RumahController::class, 'createPenghuni'])->name('create');
        Route::post('/', [RumahController::class, 'storePenghuni'])->name('store');
    });

    Route::prefix('penghuni')->name('penghuni.')->group(function () {
        Route::delete('/{id}', [RumahController::class, 'destroyPenghuni'])->name('destroy');
        Route::delete('/{id}/force', [RumahController::class, 'forceDeletePenghuni'])->name('force-delete');
    });

    // =====================================================
    // 👤 Manajemen Warga
    // =====================================================
    Route::get('/warga', [WargaController::class, 'index'])->name('warga.index');
    Route::get('/warga/create', [WargaController::class, 'create'])->name('warga.create');
    Route::post('/warga', [WargaController::class, 'store'])->name('warga.store');
    Route::get('/warga/{id}/edit', [WargaController::class, 'edit'])->name('warga.edit');
    Route::put('/warga/{id}', [WargaController::class, 'update'])->name('warga.update');
    Route::delete('/warga/{id}', [WargaController::class, 'destroy'])->name('warga.destroy');

     // 🔹 Route baru: Halaman untuk menampilkan semua Ketua RW


    // 🧾 Status Rumah
    // =====================================================
    Route::resource('status-rumah', StatusRumahController::class)->except(['show']);

    // settings
    // =====================================================
    Route::get('/setting', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('setting.index');
    Route::post('/setting/update', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('setting.update');
});
