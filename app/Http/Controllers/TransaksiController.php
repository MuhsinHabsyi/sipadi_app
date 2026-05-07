<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\StokBeras;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('pelanggan')->latest()->get();
        $stok = StokBeras::first();
        return view('transaksi.index', compact('transaksis', 'stok'));
    }

    public function create()
    {
        // Sebagai proxy untuk form pemesanan pelanggan (Katalog publik sederhana)
        $pelanggans = Pelanggan::all();
        $stok = StokBeras::first();
        return view('transaksi.create', compact('pelanggans', 'stok'));
    }

    public function store(Request $request)
    {
        // Fase 1: Pemesanan
        $request->validate([
            'id_pelanggan' => 'required|exists:pelanggans,id',
            'jumlah_pesanan' => 'required|numeric|min:1',
        ]);

        try {
            DB::beginTransaction();

            $stok = StokBeras::first();
            if (!$stok || $stok->ketersediaan_stok < $request->jumlah_pesanan) {
                return back()->withInput()->with('error', 'Pemesanan gagal! Stok beras tidak mencukupi.');
            }

            // Kurangi stok sementara
            $stok->ketersediaan_stok -= $request->jumlah_pesanan;
            $stok->save();

            Transaksi::create([
                'id_pelanggan' => $request->id_pelanggan,
                'tanggal_pesanan' => now()->toDateString(),
                'jumlah_pesanan' => $request->jumlah_pesanan,
                'status_pesanan' => Transaksi::STATUS_MENUNGGU,
            ]);

            DB::commit();
            return redirect()->route('transaksi.index')->with('success', 'Pesanan berhasil dibuat dan menunggu konfirmasi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function konfirmasi(Transaksi $transaksi)
    {
        // Fase 2: Staf konfirmasi pesanan
        if ($transaksi->status_pesanan !== Transaksi::STATUS_MENUNGGU) {
            return back()->with('error', 'Hanya pesanan berstatus Menunggu yang dapat dikonfirmasi.');
        }

        $transaksi->update(['status_pesanan' => Transaksi::STATUS_SELESAI]);

        // Stok permanen sudah dikurangi saat Menunggu, jadi tidak perlu dikurangi lagi di DB,
        // namun pada catatan bisnis "dikurangi permanen" ini berarti transaksinya final.

        return redirect()->route('transaksi.index')->with('success', 'Pesanan #'.$transaksi->id.' berhasil dikonfirmasi.');
    }

    public function batalkan(Transaksi $transaksi)
    {
        if ($transaksi->status_pesanan !== Transaksi::STATUS_MENUNGGU) {
            return back()->with('error', 'Pesanan sudah diproses dan tidak dapat dibatalkan.');
        }

        try {
            DB::beginTransaction();

            // Kembalikan stok
            $stok = StokBeras::first();
            if ($stok) {
                $stok->ketersediaan_stok += $transaksi->jumlah_pesanan;
                $stok->save();
            }

            $transaksi->update(['status_pesanan' => Transaksi::STATUS_DIBATALKAN]);

            DB::commit();
            return redirect()->route('transaksi.index')->with('success', 'Pesanan #'.$transaksi->id.' berhasil dibatalkan dan stok dikembalikan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
