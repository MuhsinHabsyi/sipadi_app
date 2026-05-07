<?php

namespace App\Http\Controllers;

use App\Models\AnggotaPetani;
use App\Models\AlokasiBibit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PertanianController extends Controller
{
    public function index()
    {
        $petanis = AnggotaPetani::with('alokasiBibits')->latest()->get();
        return view('pertanian.index', compact('petanis'));
    }

    public function create()
    {
        return view('pertanian.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_petani' => 'required|string|max:255',
            'luas_lahan' => 'required|numeric|min:0.1',
            'musim_tanam' => 'required|string|max:255',
            'jumlah_bibit' => 'required|numeric|min:1',
        ], [
            'nama_petani.required' => 'Nama Petani wajib diisi.',
            'luas_lahan.required' => 'Luas Lahan wajib diisi.',
            'musim_tanam.required' => 'Musim Tanam wajib diisi.',
            'jumlah_bibit.required' => 'Jumlah Bibit wajib diisi.',
        ]);

        try {
            DB::beginTransaction();

            $petani = AnggotaPetani::create([
                'nama_petani' => $request->nama_petani,
                'luas_lahan' => $request->luas_lahan,
            ]);

            AlokasiBibit::create([
                'id_petani' => $petani->id,
                'musim_tanam' => $request->musim_tanam,
                'jumlah_bibit' => $request->jumlah_bibit,
            ]);

            DB::commit();

            return redirect()->route('pertanian.index')->with('success', 'Data Pertanian dan Bibit berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }
}
