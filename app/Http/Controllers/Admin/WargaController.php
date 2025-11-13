<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warga;
use App\Models\Rumah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WargaController extends Controller
{
    /**
     * Menampilkan daftar warga
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $dataWarga = Warga::with('rumah')
            ->when($search, function ($query, $search) {
                $query->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('no_telp', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $dataWarga->appends(['search' => $search]);

        return view('pages.admin.warga.index', compact('dataWarga', 'search'));
    }

    /**
     * Tampilkan form tambah warga
     */
    public function create()
    {
        // Ambil daftar rumah untuk dropdown
        $rumahList = Rumah::all();
        // dd($rumahList);

        return view('pages.admin.warga.create', compact('rumahList'));
    }

    /**
     * Menyimpan data warga baru
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nik' => 'required|numeric|digits:16|unique:warga,nik',
            'nama_lengkap' => 'required|string|max:255',
            'agama' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'hubungan' => 'required|string|max:255',
            'id_rumah' => 'nullable|exists:rumah,id',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'email' => 'nullable|email|max:255',
            'no_telp' => 'nullable|digits_between:8,15',
            'gol_darah' => 'nullable|in:A,B,AB,O',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'gaji' => 'nullable|numeric|min:0',
            'pekerjaan' => 'nullable|string|max:255',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'agama.required' => 'Agama wajib dipilih.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'hubungan.required' => 'Hubungan dalam keluarga wajib diisi.',
            'foto.required' => 'Foto wajib diunggah.',
            'foto.image' => 'File foto harus berupa gambar.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
            'foto_ktp.required' => 'Foto KTP wajib diunggah.',
            'foto_ktp.image' => 'File foto KTP harus berupa gambar.',
            'foto_ktp.max' => 'Ukuran foto KTP maksimal 2MB.',
        ]);

        try {
            DB::beginTransaction();

            // Upload foto
            $fotoPath = $request->file('foto')->store('warga/foto', 'public');
            $fotoKtpPath = $request->file('foto_ktp')->store('warga/ktp', 'public');

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

            return redirect()->route('admin.warga.index')
                ->with('success', 'Data warga berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();

            // Hapus file yang sudah diupload jika terjadi error
            if (isset($fotoPath) && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
            if (isset($fotoKtpPath) && Storage::disk('public')->exists($fotoKtpPath)) {
                Storage::disk('public')->delete($fotoKtpPath);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data warga: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan form edit warga
     */
    public function edit($id)
    {
        $warga = Warga::with('rumah')->findOrFail($id);

        // Ambil daftar rumah untuk dropdown
        $rumahList = Rumah::all();

        return view('pages.admin.warga.edit', compact('warga', 'rumahList'));
    }

    /**
     * Memperbarui data warga
     */
    public function update(Request $request, $id)
    {
        $warga = Warga::findOrFail($id);

        $validatedData = $request->validate([
            'nik' => 'required|numeric|digits:16|unique:warga,nik,' . $warga->id,
            'nama_lengkap' => 'required|string|max:255',
            'agama' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'hubungan' => 'required|string|max:255',
            'id_rumah' => 'nullable|exists:rumah,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'email' => 'nullable|email|max:255',
            'no_telp' => 'nullable|digits_between:8,15',
            'gol_darah' => 'nullable|in:A,B,AB,O',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'gaji' => 'nullable|numeric|min:0',
            'pekerjaan' => 'nullable|string|max:255',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'agama.required' => 'Agama wajib dipilih.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'hubungan.required' => 'Hubungan dalam keluarga wajib diisi.',
        ]);

        try {
            DB::beginTransaction();

            $updateData = [
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
            ];

            // Update foto jika ada file baru
            if ($request->hasFile('foto')) {
                // Hapus foto lama
                if ($warga->foto && Storage::disk('public')->exists($warga->foto)) {
                    Storage::disk('public')->delete($warga->foto);
                }
                $updateData['foto'] = $request->file('foto')->store('warga/foto', 'public');
            }

            // Update foto KTP jika ada file baru
            if ($request->hasFile('foto_ktp')) {
                // Hapus foto KTP lama
                if ($warga->foto_ktp && Storage::disk('public')->exists($warga->foto_ktp)) {
                    Storage::disk('public')->delete($warga->foto_ktp);
                }
                $updateData['foto_ktp'] = $request->file('foto_ktp')->store('warga/ktp', 'public');
            }

            $warga->update($updateData);

            DB::commit();

            return redirect()->route('admin.warga.index')
                ->with('success', 'Data warga berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data warga: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data warga
     */
    public function destroy($id)
    {
        try {
            $warga = Warga::findOrFail($id);

            // Cek apakah warga adalah ketua RT atau RW
            if ($warga->rt()->exists() || $warga->rw()->exists()) {
                return redirect()->route('admin.warga.index')
                    ->with('error', 'Warga tidak dapat dihapus karena masih menjabat sebagai ketua RT/RW.');
            }

            DB::beginTransaction();

            // Hapus foto dari storage
            if ($warga->foto && Storage::disk('public')->exists($warga->foto)) {
                Storage::disk('public')->delete($warga->foto);
            }

            if ($warga->foto_ktp && Storage::disk('public')->exists($warga->foto_ktp)) {
                Storage::disk('public')->delete($warga->foto_ktp);
            }

            $warga->delete();

            DB::commit();

            return redirect()->route('admin.warga.index')
                ->with('success', 'Data warga berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.warga.index')
                ->with('error', 'Gagal menghapus data warga: ' . $e->getMessage());
        }
    }
}