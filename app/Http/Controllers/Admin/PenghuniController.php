<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penghuni;
use App\Models\Rumah;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PenghuniController extends Controller
{
  /**
   * Display a listing of penghuni for a specific rumah.
   */
  public function show($id_rumah)
  {
    try {
      $rumah = Rumah::with(['cluster.namaCluster', 'cluster.rt', 'cluster.blok'])
        ->findOrFail($id_rumah);

      $penghuni = Penghuni::with('warga')
        ->where('id_rumah', $id_rumah)
        ->orderBy('is_active', 'desc')
        ->orderBy('created_at', 'desc')
        ->get();

      return view('pages.admin.rumah.show-penghuni', compact('rumah', 'penghuni'));
    } catch (\Exception $e) {
      Log::error('Error showing penghuni: ' . $e->getMessage());
      return redirect()->route('admin.rumah.index')
        ->with('error', 'Gagal menampilkan data penghuni.');
    }
  }

  /**
   * Show the form for creating a new penghuni.
   */
  public function create($id_rumah)
  {
    try {
      $rumah = Rumah::findOrFail($id_rumah);

      // Ambil semua warga yang belum menjadi penghuni aktif di rumah ini
      $penghuniAktif = Penghuni::where('id_rumah', $id_rumah)
        ->where('is_active', true)
        ->pluck('id_warga')
        ->toArray();

      $warga = Warga::whereNotIn('id', $penghuniAktif)
        ->orderBy('nama_lengkap', 'asc')
        ->get();

      return view('pages.admin.rumah.create-penghuni', compact('rumah', 'warga'));
    } catch (\Exception $e) {
      Log::error('Error creating penghuni form: ' . $e->getMessage());
      return redirect()->route('admin.rumah.index')
        ->with('error', 'Gagal menampilkan form tambah penghuni.');
    }
  }

  /**
   * Store a newly created penghuni in storage.
   */
  public function store(Request $request, $id_rumah)
  {
    // Validasi input
    $validated = $request->validate([
      'id_warga' => 'required|exists:warga,id',
      'tipe_penghuni' => 'required|in:Pemilik,Penyewa',
      'status_penghuni' => 'required|in:Kepala Keluarga,Istri,Suami,Anak,Orang Tua,Keluarga Lainnya',
      'tanggal_masuk' => 'required|date',
      'keterangan' => 'nullable|string|max:1000',
    ], [
      'id_warga.required' => 'Warga harus dipilih.',
      'id_warga.exists' => 'Warga yang dipilih tidak valid.',
      'tipe_penghuni.required' => 'Tipe penghuni harus dipilih.',
      'tipe_penghuni.in' => 'Tipe penghuni tidak valid.',
      'status_penghuni.required' => 'Status penghuni harus dipilih.',
      'status_penghuni.in' => 'Status penghuni tidak valid. Pilih: Kepala Keluarga, Istri, Suami, Anak, Orang Tua, atau Keluarga Lainnya.',
      'tanggal_masuk.required' => 'Tanggal masuk harus diisi.',
      'tanggal_masuk.date' => 'Format tanggal masuk tidak valid.',
      'keterangan.max' => 'Keterangan maksimal 1000 karakter.',
    ]);

    DB::beginTransaction();
    try {
      // Cek apakah rumah ada
      $rumah = Rumah::findOrFail($id_rumah);

      // Cek apakah warga sudah menjadi penghuni aktif di rumah ini
      $existingPenghuni = Penghuni::where('id_rumah', $id_rumah)
        ->where('id_warga', $validated['id_warga'])
        ->where('is_active', true)
        ->first();

      if ($existingPenghuni) {
        return redirect()->back()
          ->withInput()
          ->with('error', 'Warga ini sudah terdaftar sebagai penghuni aktif di rumah ini.');
      }

      // Cek apakah sudah ada Kepala Keluarga di rumah ini
      if ($validated['status_penghuni'] === 'Kepala Keluarga') {
        $existingKK = Penghuni::where('id_rumah', $id_rumah)
          ->where('status_penghuni', 'Kepala Keluarga')
          ->where('is_active', true)
          ->first();

        if ($existingKK) {
          return redirect()->back()
            ->withInput()
            ->with('error', 'Rumah ini sudah memiliki Kepala Keluarga yang aktif.');
        }
      }

      // Simpan data penghuni
      Penghuni::create([
        'id_rumah' => $id_rumah,
        'id_warga' => $validated['id_warga'],
        'tipe_penghuni' => $validated['tipe_penghuni'],
        'status_penghuni' => $validated['status_penghuni'],
        'tanggal_masuk' => $validated['tanggal_masuk'],
        'is_active' => true,
        'keterangan' => $validated['keterangan'],
      ]);

      DB::commit();

      return redirect()->route('admin.rumah.penghuni.show', $id_rumah)
        ->with('success', 'Penghuni berhasil ditambahkan!');
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error('Error storing penghuni: ' . $e->getMessage());

      return redirect()->back()
        ->withInput()
        ->with('error', 'Gagal menambahkan penghuni. Silakan coba lagi.');
    }
  }

  /**
   * Remove the specified penghuni from storage.
   */
  public function destroy($id)
  {
    DB::beginTransaction();
    try {
      $penghuni = Penghuni::findOrFail($id);
      $id_rumah = $penghuni->id_rumah;

      // Soft delete: set is_active = false dan tanggal_keluar
      $penghuni->update([
        'is_active' => false,
        'tanggal_keluar' => now(),
      ]);

      DB::commit();

      return redirect()->route('admin.rumah.penghuni.show', $id_rumah)
        ->with('success', 'Penghuni berhasil dihapus dari rumah ini.');
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error('Error deleting penghuni: ' . $e->getMessage());

      return redirect()->back()
        ->with('error', 'Gagal menghapus penghuni. Silakan coba lagi.');
    }
  }

  /**
   * Restore (reactivate) a penghuni.
   */
  public function restore($id)
  {
    DB::beginTransaction();
    try {
      $penghuni = Penghuni::findOrFail($id);
      $id_rumah = $penghuni->id_rumah;

      // Cek apakah warga masih bisa diaktifkan kembali
      $existingActive = Penghuni::where('id_rumah', $id_rumah)
        ->where('id_warga', $penghuni->id_warga)
        ->where('is_active', true)
        ->where('id', '!=', $id)
        ->first();

      if ($existingActive) {
        return redirect()->back()
          ->with('error', 'Warga ini sudah menjadi penghuni aktif di rumah ini.');
      }

      // Aktifkan kembali
      $penghuni->update([
        'is_active' => true,
        'tanggal_keluar' => null,
      ]);

      DB::commit();

      return redirect()->route('admin.rumah.penghuni.show', $id_rumah)
        ->with('success', 'Penghuni berhasil diaktifkan kembali.');
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error('Error restoring penghuni: ' . $e->getMessage());

      return redirect()->back()
        ->with('error', 'Gagal mengaktifkan kembali penghuni. Silakan coba lagi.');
    }
  }
}
