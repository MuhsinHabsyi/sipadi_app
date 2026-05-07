<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PelangganAuthController extends Controller
{
    /** Halaman login pelanggan */
    public function showLogin()
    {
        if (session()->has('pelanggan_id')) {
            return redirect()->route('toko');
        }
        return view('toko.login');
    }

    /** Halaman register pelanggan */
    public function showRegister()
    {
        if (session()->has('pelanggan_id')) {
            return redirect()->route('toko');
        }
        return view('toko.register');
    }

    /** Proses login */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $pelanggan = Pelanggan::where('email', $request->email)->first();

        if (! $pelanggan || ! Hash::check($request->password, $pelanggan->password)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau kata sandi salah.']);
        }

        session([
            'pelanggan_id'   => $pelanggan->id,
            'pelanggan_nama' => $pelanggan->nama,
            'pelanggan_email' => $pelanggan->email,
        ]);

        $request->session()->regenerate();

        $intended = session('url.intended', route('toko'));
        session()->forget('url.intended');
        return redirect($intended);
    }

    /** Proses register */
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pelanggans,email',
            'password' => 'required|string|min:6|confirmed',
            'kontak' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'kontak.required' => 'Nomor telepon wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
        ]);

        $pelanggan = Pelanggan::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'kontak' => $request->kontak,
            'telepon' => $request->kontak,
            'alamat' => $request->alamat,
        ]);

        session([
            'pelanggan_id'   => $pelanggan->id,
            'pelanggan_nama' => $pelanggan->nama,
            'pelanggan_email' => $pelanggan->email,
        ]);

        $request->session()->regenerate();

        $intended = session('url.intended', route('toko'));
        session()->forget('url.intended');
        return redirect($intended)->with('success', 'Registrasi berhasil! Selamat datang, ' . $pelanggan->nama);
    }

    /** Logout */
    public function logout(Request $request)
    {
        $request->session()->forget(['pelanggan_id', 'pelanggan_nama', 'pelanggan_email', 'url.intended']);

        return redirect()->route('toko')->with('success', 'Anda berhasil keluar.');
    }
}
