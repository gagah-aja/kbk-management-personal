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
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                      ->orWhere('nik', 'like', "%{$search}%")
                      ->orWhere('no_telp', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('pages.admin.warga.index', compact('dataWarga', 'search'));
    }

    /**
     * Menampilkan form tambah warga
     */
    public function create()
    {
        $rumahList = Rumah::all();
        return view('pages.admin.warga.create', compact('rumahList'));
    }

    /**
     * Menyimpan data warga baru
     */
    public function store(Request $request)
    {
        // Convert gaji: "1.500.000" -> "1500000"
        $cleanGaji = $request->gaji ? str_replace('.', '', $request->gaji) : null;

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
            'pekerjaan' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            // Upload foto
            $fotoPath = $request->file('foto')->store('warga/foto', 'public');
            $fotoKtpPath = $request->file('foto_ktp')->store('warga/ktp', 'public');

            Warga::create([
                ...$validatedData,
                'gaji' => $cleanGaji,
                'foto' => $fotoPath,
                'foto_ktp' => $fotoKtpPath,
            ]);

            DB::commit();

            return redirect()->route('admin.warga.index')
                ->with('success', 'Data warga berhasil ditambahkan!');
        } catch (\Exception $e) {

            // Rollback + delete uploaded files
            DB::rollBack();
            if (!empty($fotoPath) && Storage::disk('public')->exists($fotoPath)) Storage::disk('public')->delete($fotoPath);
            if (!empty($fotoKtpPath) && Storage::disk('public')->exists($fotoKtpPath)) Storage::disk('public')->delete($fotoKtpPath);

            return back()->withInput()->with('error', 'Gagal menambahkan data warga: ' . $e->getMessage());
        }
    }

    /**
     * Form edit warga
     */
    public function edit($id)
    {
        $warga = Warga::with('rumah')->findOrFail($id);
        $rumahList = Rumah::all();

        return view('pages.admin.warga.edit', compact('warga', 'rumahList'));
    }

    /**
     * Update warga
     */
    public function update(Request $request, $id)
    {
        $warga = Warga::findOrFail($id);

        // Convert format gaji
        $cleanGaji = $request->gaji ? str_replace('.', '', $request->gaji) : null;

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
            'pekerjaan' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $updateData = [
                ...$validatedData,
                'gaji' => $cleanGaji,
            ];

            // Update foto warga
            if ($request->hasFile('foto')) {
                if ($warga->foto && Storage::disk('public')->exists($warga->foto)) {
                    Storage::disk('public')->delete($warga->foto);
                }
                $updateData['foto'] = $request->file('foto')->store('warga/foto', 'public');
            }

            // Update foto KTP
            if ($request->hasFile('foto_ktp')) {
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
            return back()->withInput()->with('error', 'Gagal memperbarui data warga: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data warga
     */
    public function destroy($id)
    {
        try {
            $warga = Warga::findOrFail($id);

            // Cek apakah warga masih menjabat
            if ($warga->rt()->exists() || $warga->rw()->exists()) {
                return redirect()->route('admin.warga.index')
                    ->with('error', 'Warga tidak dapat dihapus karena masih menjabat sebagai ketua RT/RW.');
            }

            DB::beginTransaction();

            // Delete images
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
