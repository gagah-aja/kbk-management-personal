<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('pages.auth.login');
    }
    public function authenticate(Request $request)
    {
        // 1. Validasi Data
        $credentials = $request->validate([
            'username'=>['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();  
            return redirect()->intended('/dashboard')->with('success', 'Anda berhasil login!');
        }
        return back()->withErrors([
            'email' => 'Email atau Password yang Anda masukkan salah.',
        ])->onlyInput('email'); // Hanya simpan input email
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Anda berhasil logout.');
    }
}
