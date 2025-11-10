<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StatusRumah;
use App\Models\Rumah;

class StatusRumahController extends Controller
{
    public function index()
    {
        $statuses = StatusRumah::withCount('rumah')->orderBy('id')->get();
        return view('pages.admin.status-rumah.index', compact('statuses'));
    }

    public function create()
    {
        return view('pages.admin.status-rumah.create');
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
