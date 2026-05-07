<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AutentikasiController extends Controller
{
    /** Tampilkan halaman login */
    public function showLogin()
    {
        if (session()->has('pengguna_id')) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    /** Proses login */
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $pengguna = Pengguna::where('username', $request->username)->first();

        if (! $pengguna || ! Hash::check($request->password, $pengguna->password)) {
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['username' => 'Username atau kata sandi salah.']);
        }

        // Simpan sesi pengguna
        session([
            'pengguna_id'       => $pengguna->id,
            'pengguna_username' => $pengguna->username,
            'pengguna_role'     => $pengguna->role,
        ]);

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    /** Logout */
    public function logout(Request $request)
    {
        $request->session()->forget(['pengguna_id', 'pengguna_username', 'pengguna_role']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
