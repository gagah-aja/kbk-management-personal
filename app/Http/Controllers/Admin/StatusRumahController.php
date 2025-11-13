<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StatusRumah;
use App\Models\Rumah;

class StatusRumahController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $statuses = \App\Models\StatusRumah::withCount('rumah')
        ->when($search, function($query, $search) {
            $query->where('nama_status', 'like', "%{$search}%");
        })
        ->orderBy('id', 'asc')
        ->paginate(10)
        ->withQueryString(); // Supaya query search terbawa saat pindah halaman

    return view('pages.admin.status-rumah.index', compact('statuses', 'search'));
}


    public function store(Request $request)
    {
        $request->validate([
            'nama_status' => 'required|string|max:255',
        ]);

        StatusRumah::create($request->only('nama_status'));

        return redirect()->route('admin.status-rumah.index')->with('success', 'Status rumah berhasil ditambahkan.');
    }

    public function edit(StatusRumah $statusRumah)
    {
        return view('pages.admin.status-rumah.edit', ['status' => $statusRumah]);
    }

    public function update(Request $request, StatusRumah $statusRumah)
    {
        $request->validate([
            'nama_status' => 'required|string|max:255',
        ]);

        $statusRumah->update($request->only('nama_status'));

        return redirect()->route('admin.status-rumah.index')->with('success', 'Status rumah berhasil diperbarui.');
    }

    public function destroy(StatusRumah $statusRumah)
    {
        if ($statusRumah->rumah()->count() > 0) {
            return redirect()->route('admin.status-rumah.index')
                ->with('error', 'Tidak dapat menghapus: status ini masih dipakai di data rumah.');
        }

        $statusRumah->delete();
        return redirect()->route('admin.status-rumah.index')->with('success', 'Status rumah berhasil dihapus.');
    }
}
