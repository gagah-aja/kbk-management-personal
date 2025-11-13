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
            'landing_page' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $setting = Setting::firstOrNew(['key' => 'landing_page']);

        // Hapus file lama kalau ada
        if ($setting->value && Storage::exists('public/' . $setting->value)) {
            Storage::delete('public/' . $setting->value);
        }

        // Simpan file baru
        $path = $request->file('landing_page')->store('landing', 'public');
        $setting->value = $path;
        $setting->save();

        return redirect()->back()->with('success', 'Gambar landing page berhasil diperbarui!');
    }
}
