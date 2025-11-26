<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Tampilkan halaman setting
     */
    public function index()
    {
        $landingPage = Setting::where('key', 'landing_page')->first();
        $mapPolygon  = Setting::where('key', 'map_polygon')->first();

        return view('pages.admin.setting.index', compact('landingPage', 'mapPolygon'));
    }

    /**
     * Update gambar landing page & polygon map
     */
    public function update(Request $request)
{
    $request->validate([
        'landing_page' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        'map_polygon'  => 'nullable|string',
    ]);

    try {
        // ============================
        // 1) SIMPAN GAMBAR LANDING PAGE
        // ============================
        if ($request->hasFile('landing_page')) {

            $file = $request->file('landing_page');
            $path = $file->store('landing', 'public');

            // Hapus file lama jika ada
            $old = Setting::where('key', 'landing_page')->first();
            if ($old && $old->value && Storage::disk('public')->exists($old->value)) {
                Storage::disk('public')->delete($old->value);
            }

            // Simpan atau update
            Setting::updateOrCreate(
                ['key' => 'landing_page'],
                ['value' => $path]
            );
        }

        // ============================
        // 2) SIMPAN POLYGON PETA
        // ============================
        // Simpan polygon walau kosong
        Setting::updateOrCreate(
            ['key' => 'map_polygon'],
            ['value' => $request->map_polygon ?? '']
        );

        return back()->with('success', 'Setting berhasil diperbarui!');
    } catch (\Exception $e) {
        return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

}
