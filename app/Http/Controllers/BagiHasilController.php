<?php

namespace App\Http\Controllers;

use App\Models\ArusKas;
use App\Models\DataPanen;
use App\Models\PembagianHasil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BagiHasilController extends Controller
{
    public function index()
    {
        $bagiHasils = PembagianHasil::with('petani')->latest()->get();
        // Kelompokkan berdasarkan musim_tanam untuk rekap
        $rekapMusim = $bagiHasils->groupBy('musim_tanam')->map(function ($group) {
            return [
                'musim_tanam' => $group->first()->musim_tanam,
                'total_keuntungan' => $group->first()->total_keuntungan,
                'jumlah_petani' => $group->count(),
                'tanggal_dibagi' => $group->first()->created_at,
            ];
        });

        return view('bagi_hasil.index', compact('bagiHasils', 'rekapMusim'));
    }

    public function create(Request $request)
    {
        $musim_tanam = $request->query('musim_tanam');
        
        // Ambil daftar musim tanam unik dari data panen
        $listMusim = DataPanen::select('musim_tanam')->distinct()->pluck('musim_tanam');

        $previewData = null;
        $totalKeuntungan = 0;
        $error = null;

        if ($musim_tanam) {
            // Cek apakah sudah pernah dibagi untuk musim ini
            $sudahDibagi = PembagianHasil::where('musim_tanam', $musim_tanam)->exists();
            
            if ($sudahDibagi) {
                $error = "Pembagian hasil untuk musim tanam $musim_tanam sudah dilakukan sebelumnya.";
            } else {
                // 1. Cek Kelengkapan Data Kas (Simulasi sederhana: jika ada pemasukan dan pengeluaran terkait musim ini)
                // Dalam skenario nyata, mungkin ada flag khusus di ArusKas. Kita asumsikan hitung semua kas saat ini.
                // Atau bisa dari tanggal awal musim tanam sampai akhir. Di sini kita hitung seluruh saldo positif.
                $pemasukan = ArusKas::where('musim_tanam', $musim_tanam)->where('jenis_transaksi', 'pemasukan')->sum('nominal');
                $pengeluaran = ArusKas::where('musim_tanam', $musim_tanam)->where('jenis_transaksi', 'pengeluaran')->sum('nominal');
                $totalKeuntungan = $pemasukan - $pengeluaran;

                if ($totalKeuntungan <= 0) {
                    $error = "Data kas tidak memadai atau keuntungan belum positif. Pastikan data arus kas lengkap!";
                } else {
                    // Ambil panen musim tersebut
                    $dataPanenMusim = DataPanen::with('petani')->where('musim_tanam', $musim_tanam)->get();
                    
                    if ($dataPanenMusim->isEmpty()) {
                        $error = "Tidak ada data panen untuk musim tanam $musim_tanam.";
                    } else {
                        $totalPanenSemua = $dataPanenMusim->sum('total_panen');
                        
                        $previewData = [];
                        foreach ($dataPanenMusim as $panen) {
                            $proporsi = ($panen->total_panen / $totalPanenSemua) * 100;
                            $alokasi = ($proporsi / 100) * $totalKeuntungan;
                            
                            $previewData[] = [
                                'id_petani' => $panen->id_petani,
                                'nama_petani' => $panen->petani->nama_petani,
                                'total_panen' => $panen->total_panen,
                                'proporsi_panen' => round($proporsi, 2),
                                'alokasi_keuntungan' => round($alokasi, 2),
                            ];
                        }
                    }
                }
            }
        }

        return view('bagi_hasil.create', compact('listMusim', 'musim_tanam', 'previewData', 'totalKeuntungan', 'error'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'musim_tanam' => 'required|string',
        ]);

        $musim_tanam = $request->musim_tanam;

        if (PembagianHasil::where('musim_tanam', $musim_tanam)->exists()) {
            return back()->with('error', 'Gagal! Pembagian hasil musim ini sudah ada.');
        }

        // Recalculate on server to ensure data integrity
        $pemasukan = ArusKas::where('musim_tanam', $musim_tanam)->where('jenis_transaksi', 'pemasukan')->sum('nominal');
        $pengeluaran = ArusKas::where('musim_tanam', $musim_tanam)->where('jenis_transaksi', 'pengeluaran')->sum('nominal');
        $totalKeuntungan = $pemasukan - $pengeluaran;

        if ($totalKeuntungan <= 0) {
            return back()->with('error', 'Kalkulasi gagal: Keuntungan tidak valid atau <= 0.');
        }

        $dataPanenMusim = DataPanen::where('musim_tanam', $musim_tanam)->get();
        if ($dataPanenMusim->isEmpty()) {
            return back()->with('error', 'Kalkulasi gagal: Data panen tidak ditemukan.');
        }

        $totalPanenSemua = $dataPanenMusim->sum('total_panen');

        try {
            DB::beginTransaction();

            $inserts = [];
            $now = now()->toDateTimeString();
            
            foreach ($dataPanenMusim as $panen) {
                $proporsi = ($panen->total_panen / $totalPanenSemua) * 100;
                $alokasi = ($proporsi / 100) * $totalKeuntungan;

                $inserts[] = [
                    'id_petani' => $panen->id_petani,
                    'musim_tanam' => $musim_tanam,
                    'proporsi_panen' => round($proporsi, 2),
                    'alokasi_keuntungan' => round($alokasi, 2),
                    'total_keuntungan' => $totalKeuntungan,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            PembagianHasil::insert($inserts);

            DB::commit();
            return redirect()->route('bagi-hasil.index')->with('success', "Pembagian Hasil untuk musim $musim_tanam berhasil disimpan.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}
