<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WargaController extends Controller
{
    public function index()
    {
        $warga = Warga::paginate(10);
        return view('pages.admin.warga', compact('warga'));
    }
    public function tambah_halaman()
    {
        return view('pages.admin.tambah_warga');
    }
      public function tambah(Request $request)
    {

        try {
            $validatedData = $request->validate([
                'nik' => 'required|string|unique:warga,nik|max:16',
                'nama_lengkap' => 'required|string|max:255',
                'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
                'hubungan' => 'required|string|max:255',
                'pekerjaan' => 'required|string|max:255',
                'tanggal_lahir' => 'nullable|date',
                'pendidikan' => 'nullable|string|max:255',
                'id_rumah' => 'nullable|integer',

                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'foto_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangani error validasi dan kembali dengan pesan error
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        $fotoPath = null;
        $fotoKtpPath = null;

        try {
            // Memulai transaksi database
            DB::beginTransaction();

            // 2. UNGGAH FOTO WARGA & KTP
            // File dipastikan ada setelah lolos validasi 'required'.
            $fotoPath = $this->uploadFile($request->file('foto'), 'warga/foto');
            $fotoKtpPath = $this->uploadFile($request->file('foto_ktp'), 'warga/ktp');

            // 3. SIMPAN DATA KE DATABASE (Kode Warga::create diaktifkan)
            Warga::create([
                'nik' => $validatedData['nik'],
                'nama_lengkap' => $validatedData['nama_lengkap'],
                'jenis_kelamin' => $validatedData['jenis_kelamin'],
                'hubungan' => $validatedData['hubungan'],
                'pekerjaan' => $validatedData['pekerjaan'],
                // Gunakan null-coalescing untuk menangani 'tanggal_lahir' yang mungkin null karena dibuat 'nullable' di validasi
                'tanggal_lahir' => $validatedData['tanggal_lahir'] ?? null,
                'pendidikan' => $validatedData['pendidikan'],
                'id_rumah' => $validatedData['id_rumah'] ?? null,
                'foto' => $fotoPath, // Path file foto
                'foto_ktp' => $fotoKtpPath, // Path file foto KTP
            ]);

            DB::commit(); // Komit transaksi jika berhasil

            // Redirect dengan pesan sukses
            return redirect()->route('admin.warga.tambah.halaman')->with('success', 'Data Warga berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi kesalahan

            // Hapus file yang sudah terlanjur terupload jika terjadi kegagalan DB
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
            if ($fotoKtpPath && Storage::disk('public')->exists($fotoKtpPath)) {
                Storage::disk('public')->delete($fotoKtpPath);
            }

            // Redirect dengan pesan error dan tampilkan error detail untuk debugging
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data warga: ' . $e->getMessage());
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
