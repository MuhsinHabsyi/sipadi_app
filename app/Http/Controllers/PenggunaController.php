<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PenggunaController extends Controller
{
    public function index()
    {
        $penggunas = Pengguna::latest()->get();
        return view('pengguna.index', compact('penggunas'));
    }

    public function create()
    {
        return view('pengguna.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:penggunas,username',
            'password' => 'required|string|min:6',
            'role' => ['required', Rule::in([Pengguna::ROLE_KETUA, Pengguna::ROLE_STAF_PRODUKSI, Pengguna::ROLE_STAF_PENJUALAN, Pengguna::ROLE_STAF_KEUANGAN])],
        ], [
            'username.unique' => 'Username ini sudah digunakan.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
        ]);

        Pengguna::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function edit(Pengguna $pengguna)
    {
        return view('pengguna.edit', compact('pengguna'));
    }

    public function update(Request $request, Pengguna $pengguna)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('penggunas')->ignore($pengguna->id)],
            'password' => 'nullable|string|min:6',
            'role' => ['required', Rule::in([Pengguna::ROLE_KETUA, Pengguna::ROLE_STAF_PRODUKSI, Pengguna::ROLE_STAF_PENJUALAN, Pengguna::ROLE_STAF_KEUANGAN])],
        ]);

        $data = [
            'username' => $request->username,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pengguna->update($data);

        // Jika mengedit akun sendiri dan role berubah atau password berubah, sebaiknya relogin
        if ($pengguna->id == session('pengguna_id') && ($request->filled('password') || $pengguna->role != session('pengguna_role'))) {
            return redirect()->route('autentikasi.logout');
        }

        return redirect()->route('pengguna.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(Pengguna $pengguna)
    {
        if ($pengguna->id == session('pengguna_id')) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang digunakan.');
        }

        $pengguna->delete();
        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
