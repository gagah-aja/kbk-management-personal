<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StatusRumah;
use App\Models\Rumah;
use Illuminate\Support\Facades\DB;

class StatusRumahController extends Controller
{
    /**
     * Menampilkan daftar status rumah
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $statuses = StatusRumah::withCount('rumah')
            ->when($search, function($query, $search) {
                $query->where('nama_status', 'like', "%{$search}%");
            })
            ->orderBy('id', 'asc')
            ->paginate(10);

        $statuses->appends(['search' => $search]);

        return view('pages.admin.status-rumah.index', compact('statuses', 'search'));
    }

    /**
     * Tampilkan form tambah status rumah
     */
    public function create()
    {
        return view('pages.admin.status-rumah.create');
    }

    /**
     * Menyimpan status rumah baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_status' => 'required|string|max:255|unique:status_rumah,nama_status',
        ], [
            'nama_status.required' => 'Nama status wajib diisi.',
            'nama_status.unique' => 'Nama status sudah terdaftar.',
        ]);

        StatusRumah::create($request->only('nama_status'));

        return redirect()->route('admin.status-rumah.index')
            ->with('success', 'Status rumah berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit status rumah
     */
    public function edit(StatusRumah $statusRumah)
    {
        return view('pages.admin.status-rumah.edit', ['status' => $statusRumah]);
    }

    /**
     * Memperbarui status rumah
     */
    public function update(Request $request, StatusRumah $statusRumah)
    {
        $request->validate([
            'nama_status' => 'required|string|max:255|unique:status_rumah,nama_status,' . $statusRumah->id,
        ], [
            'nama_status.required' => 'Nama status wajib diisi.',
            'nama_status.unique' => 'Nama status sudah terdaftar.',
        ]);

        $statusRumah->update($request->only('nama_status'));

        return redirect()->route('admin.status-rumah.index')
            ->with('success', 'Status rumah berhasil diperbarui!');
    }

    /**
     * Menghapus status rumah
     */
    public function destroy(StatusRumah $statusRumah)
    {
        try {
            // Cek apakah status masih digunakan
            if ($statusRumah->rumah()->count() > 0) {
                return redirect()->route('admin.status-rumah.index')
                    ->with('error', 'Status rumah tidak dapat dihapus karena masih digunakan oleh rumah.');
            }

            $statusRumah->delete();

            // Reset auto increment jika tabel kosong
            if (StatusRumah::count() === 0) {
                DB::statement('ALTER TABLE status_rumah AUTO_INCREMENT = 1;');
            }

            return redirect()->route('admin.status-rumah.index')
                ->with('success', 'Status rumah berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.status-rumah.index')
                ->with('error', 'Gagal menghapus status rumah: ' . $e->getMessage());
        }
    }
}