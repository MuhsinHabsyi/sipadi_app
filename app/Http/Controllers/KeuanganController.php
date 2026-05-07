<?php

namespace App\Http\Controllers;

use App\Models\ArusKas;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index()
    {
        $arusKas = ArusKas::latest()->get();
        
        $pemasukan = $arusKas->where('jenis_transaksi', ArusKas::JENIS_PEMASUKAN)->sum('nominal');
        $pengeluaran = $arusKas->where('jenis_transaksi', ArusKas::JENIS_PENGELUARAN)->sum('nominal');
        $saldo = $pemasukan - $pengeluaran;

        return view('keuangan.index', compact('arusKas', 'pemasukan', 'pengeluaran', 'saldo'));
    }

    public function create()
    {
        $listMusim = \App\Models\DataPanen::select('musim_tanam')->distinct()->pluck('musim_tanam');
        return view('keuangan.create', compact('listMusim'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'musim_tanam' => 'required|string',
            'jenis_transaksi' => 'required|in:pemasukan,pengeluaran',
            'nominal' => 'required|numeric|min:1',
            'keterangan' => 'required|string|max:255',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi.',
            'musim_tanam.required' => 'Musim tanam wajib diisi.',
            'jenis_transaksi.required' => 'Jenis transaksi wajib dipilih.',
            'nominal.required' => 'Nominal wajib diisi.',
            'nominal.min' => 'Nominal harus lebih besar dari 0.',
            'keterangan.required' => 'Keterangan wajib diisi.',
        ]);

        ArusKas::create([
            'tanggal' => $request->tanggal,
            'musim_tanam' => $request->musim_tanam,
            'jenis_transaksi' => $request->jenis_transaksi,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('keuangan.index')->with('success', 'Data Arus Kas berhasil dicatat.');
    }
}
