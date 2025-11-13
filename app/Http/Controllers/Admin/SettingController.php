<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $landingPage = Setting::where('key', 'landing_page')->first();
        return view('pages.admin.setting.index', compact('landingPage'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'landing_page' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $setting = Setting::firstOrCreate(['key' => 'landing_page']);

        if ($request->hasFile('landing_page')) {
            // Hapus gambar lama
            if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                Storage::disk('public')->delete($setting->value);
            }

            // Simpan gambar baru
            $path = $request->file('landing_page')->store('landing_page', 'public');
            $setting->update(['value' => $path]);
        }

        return redirect()->back()->with('success', 'Gambar landing page berhasil diperbarui!');
    }
}
