<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WargaController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $warga = Warga::when($search, function ($query, $search) {
        $query->where('nama_lengkap', 'like', "%{$search}%")
              ->orWhere('nik', 'like', "%{$search}%");
    })->paginate(10);

    $warga->appends(['search' => $search]);

    return view('pages.admin.warga', compact('warga', 'search'));
}

    public function tambah_halaman()
    {
        return view('pages.admin.tambah_warga');
    }
    public function tambah(Request $request)
    {
        try {
            // dd($request);
            // ✅ VALIDASI DATA
            $validatedData = $request->validate([
                'nik' => 'required|numeric|digits:16|unique:warga,nik', // pastikan nama tabel sesuai
                'nama_lengkap' => 'required|string|max:255',
                'agama' => 'required|string|max:100',
                'tanggal_lahir' => 'required|date',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'hubungan' => 'required|string|max:255',
                'id_rumah' => 'nullable',
                'foto' => 'required|image|mimes:jpeg,png,jpg',
                'foto_ktp' => 'required|image|mimes:jpeg,png,jpg',

                // Opsional
                'email' => 'nullable|email|max:255',
                'no_telp' => 'nullable|digits_between:8,15',
                'gol_darah' => 'nullable|in:A,B,AB,O',
                'pendidikan_terakhir' => 'nullable|string|max:255',
                'gaji' => 'nullable|numeric|min:0',
                'pekerjaan' => 'nullable|string|max:255',
            ]);

            DB::beginTransaction();

            // ✅ UPLOAD FOTO
            $fotoPath = $request->file('foto')->store('warga/foto', 'public');
            $fotoKtpPath = $request->file('foto_ktp')->store('warga/ktp', 'public');

            // ✅ SIMPAN KE DATABASE
            Warga::create([
                'nik' => $validatedData['nik'],
                'nama_lengkap' => $validatedData['nama_lengkap'],
                'agama' => $validatedData['agama'],
                'tanggal_lahir' => $validatedData['tanggal_lahir'],
                'jenis_kelamin' => $validatedData['jenis_kelamin'],
                'hubungan' => $validatedData['hubungan'],
                'id_rumah' => $validatedData['id_rumah'],

                'email' => $validatedData['email'] ?? null,
                'no_telp' => $validatedData['no_telp'] ?? null,
                'gol_darah' => $validatedData['gol_darah'] ?? null,
                'pendidikan_terakhir' => $validatedData['pendidikan_terakhir'] ?? null,
                'gaji' => $validatedData['gaji'] ?? null,
                'pekerjaan' => $validatedData['pekerjaan'] ?? null,

                'foto' => $fotoPath,
                'foto_ktp' => $fotoKtpPath,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.warga.tambah.halaman')
                ->with('success', 'Data warga berhasil ditambahkan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // ✅ Jika validasi gagal
            // dd($e->validator);
            return redirect()
                ->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            // dd($e);
            DB::rollBack();
            // dd($e->getMessage());

            // ✅ Hapus file yang terlanjur terupload jika gagal
            if (!empty($fotoPath) && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
            if (!empty($fotoKtpPath) && Storage::disk('public')->exists($fotoKtpPath)) {
                Storage::disk('public')->delete($fotoKtpPath);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function edit_halaman($id)
    {
        $warga = Warga::find($id);
        return view('pages.admin.edit_warga', compact('warga'));
    }
    public function update(Request $request, $id)
    {
        // Cari data warga yang akan diupdate
        $warga = Warga::findOrFail($id);

        // Variabel untuk menyimpan path file lama
        $oldFotoPath = $warga->foto;
        $oldFotoKtpPath = $warga->foto_ktp;

        try {
            // ✅ VALIDASI DATA
            // PENTING: Untuk 'nik', rule 'unique' harus diabaikan untuk NIK milik warga yang sedang diedit ($id)
            $validatedData = $request->validate([
                'nik' => 'required|numeric|digits:16|unique:warga,nik,' . $id,
                'nama_lengkap' => 'required|string|max:255',
                'agama' => 'required|string|max:100',
                'tanggal_lahir' => 'required|date',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'hubungan' => 'required|string|max:255',
                'id_rumah' => 'nullable',
                // 'foto' dan 'foto_ktp' dibuat 'nullable' karena file lama bisa dipertahankan
                'foto' => 'nullable|image|mimes:jpeg,png,jpg',
                'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg',

                // Opsional
                'email' => 'nullable|email|max:255',
                'no_telp' => 'nullable|digits_between:8,15',
                'gol_darah' => 'nullable|in:A,B,AB,O',
                'pendidikan_terakhir' => 'nullable|string|max:255',
                'gaji' => 'nullable|numeric|min:0',
                'pekerjaan' => 'nullable|string|max:255',
            ]);

            DB::beginTransaction();

            // 🖼️ PENANGANAN UPLOAD FOTO BARU

            // Inisialisasi path baru dengan path lama (jika tidak ada upload baru)
            $fotoPath = $oldFotoPath;
            $fotoKtpPath = $oldFotoKtpPath;

            if ($request->hasFile('foto')) {
                // Upload foto baru
                $fotoPath = $request->file('foto')->store('warga/foto', 'public');
                // Hapus foto lama jika ada
                if ($oldFotoPath && Storage::disk('public')->exists($oldFotoPath)) {
                    Storage::disk('public')->delete($oldFotoPath);
                }
            }

            if ($request->hasFile('foto_ktp')) {
                // Upload foto KTP baru
                $fotoKtpPath = $request->file('foto_ktp')->store('warga/ktp', 'public');
                // Hapus foto KTP lama jika ada
                if ($oldFotoKtpPath && Storage::disk('public')->exists($oldFotoKtpPath)) {
                    Storage::disk('public')->delete($oldFotoKtpPath);
                }
            }

            // ✅ PERBARUI DATA DI DATABASE
            $warga->update([
                'nik' => $validatedData['nik'],
                'nama_lengkap' => $validatedData['nama_lengkap'],
                'agama' => $validatedData['agama'],
                'tanggal_lahir' => $validatedData['tanggal_lahir'],
                'jenis_kelamin' => $validatedData['jenis_kelamin'],
                'hubungan' => $validatedData['hubungan'],
                'id_rumah' => $validatedData['id_rumah'],

                'email' => $validatedData['email'] ?? null,
                'no_telp' => $validatedData['no_telp'] ?? null,
                'gol_darah' => $validatedData['gol_darah'] ?? null,
                'pendidikan_terakhir' => $validatedData['pendidikan_terakhir'] ?? null,
                'gaji' => $validatedData['gaji'] ?? null,
                'pekerjaan' => $validatedData['pekerjaan'] ?? null,

                'foto' => $fotoPath, // Menggunakan path baru atau lama
                'foto_ktp' => $fotoKtpPath, // Menggunakan path baru atau lama
            ]);

            DB::commit();

            return redirect()
                ->route('admin.warga.index') // Biasanya redirect ke halaman list/index setelah update
                ->with('success', 'Data warga berhasil diperbarui!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // ✅ Jika validasi gagal
            return redirect()
                ->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();

            // Hapus file baru yang terlanjur terupload jika terjadi kegagalan DB setelah upload
            if ($request->hasFile('foto') && Storage::disk('public')->exists($fotoPath) && $fotoPath != $oldFotoPath) {
                Storage::disk('public')->delete($fotoPath);
            }
            if ($request->hasFile('foto_ktp') && Storage::disk('public')->exists($fotoKtpPath) && $fotoKtpPath != $oldFotoKtpPath) {
                Storage::disk('public')->delete($fotoKtpPath);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function hapus($id)
    {
        // Cari data warga, atau tampilkan 404 jika tidak ditemukan
        $warga = Warga::findOrFail($id);

        try {
            // Memulai transaksi database
            DB::beginTransaction();

            // 1. HAPUS FILE FOTO DARI STORAGE
            if ($warga->foto) {
                // Hapus foto warga dari disk 'public'
                Storage::disk('public')->delete($warga->foto);
            }
            if ($warga->foto_ktp) {
                // Hapus foto KTP dari disk 'public'
                Storage::disk('public')->delete($warga->foto_ktp);
            }

            // 2. HAPUS RECORD DARI DATABASE
            $warga->delete();

            DB::commit();

            // Redirect dengan pesan sukses
            return redirect()->route('admin.warga.index')->with('success', 'Data Warga ' . $warga->nama_lengkap . ' berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Redirect dengan pesan error
            return redirect()->back()->with('error', 'Gagal menghapus data warga: ' . $e->getMessage());
        }
    }

    /**
     * Memproses upload file ke storage Laravel.
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @return string Path file yang disimpan relatif terhadap disk.
     */
    protected function uploadFile($file, $folder)
    {
        // Menghasilkan nama file acak (unik)
        $fileName = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Menyimpan file ke disk 'public' di dalam folder yang ditentukan
        // dan mengembalikan path lengkapnya
        return $file->storeAs($folder, $fileName, 'public');
    }
}
