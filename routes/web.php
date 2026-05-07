<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutentikasiController;
use App\Http\Controllers\PertanianController;
use App\Http\Controllers\CuacaController;
use App\Http\Controllers\PanenController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\BagiHasilController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenggunaController;

/*
|--------------------------------------------------------------------------
| Autentikasi (publik)
|--------------------------------------------------------------------------
*/
Route::get('/', [AutentikasiController::class, 'showLogin'])->name('autentikasi.showLogin');
Route::get('/login', [AutentikasiController::class, 'showLogin'])->name('login');
Route::post('/login', [AutentikasiController::class, 'login'])->name('autentikasi.login');
Route::post('/logout', [AutentikasiController::class, 'logout'])->name('autentikasi.logout');

/*
|--------------------------------------------------------------------------
| Rute Internal — wajib login (semua role)
|--------------------------------------------------------------------------
*/
Route::middleware('pengguna.auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        $stokBeras        = \App\Models\StokBeras::value('ketersediaan_stok') ?? 0;
        $totalPetani      = \App\Models\AnggotaPetani::count();
        $totalTransaksi   = \App\Models\Transaksi::count();
        $transaksiMenunggu = \App\Models\Transaksi::where('status_pesanan', 'Menunggu')->count();
        $pemasukan        = \App\Models\ArusKas::where('jenis_transaksi', 'pemasukan')->sum('nominal');
        $pengeluaran      = \App\Models\ArusKas::where('jenis_transaksi', 'pengeluaran')->sum('nominal');
        $saldoKas         = $pemasukan - $pengeluaran;
        $transaksiTerbaru = \App\Models\Transaksi::with('pelanggan')
                                ->latest()
                                ->take(5)
                                ->get();

        return view('dashboard', compact(
            'stokBeras', 'totalPetani', 'totalTransaksi',
            'transaksiMenunggu', 'saldoKas', 'transaksiTerbaru'
        ));
    })->name('dashboard');

    /*
    |--------------------------------------------------------------
    | Produksi — Staf Produksi & Ketua
    |--------------------------------------------------------------
    */
    Route::middleware('pengguna.auth:ketua,staf_produksi')->group(function () {
        Route::resource('pertanian', PertanianController::class);
        Route::resource('panen', PanenController::class);
        Route::get('cuaca', [CuacaController::class, 'index'])->name('cuaca.index');
    });

    /*
    |--------------------------------------------------------------
    | Penjualan — Staf Penjualan & Ketua
    |--------------------------------------------------------------
    */
    Route::middleware('pengguna.auth:ketua,staf_penjualan')->group(function () {
        Route::resource('transaksi', TransaksiController::class);
        Route::patch('transaksi/{transaksi}/konfirmasi', [TransaksiController::class, 'konfirmasi'])
             ->name('transaksi.konfirmasi');
        Route::patch('transaksi/{transaksi}/batalkan', [TransaksiController::class, 'batalkan'])
             ->name('transaksi.batalkan');
    });

    /*
    |--------------------------------------------------------------
    | Keuangan — Staf Keuangan & Ketua
    |--------------------------------------------------------------
    */
    Route::middleware('pengguna.auth:ketua,staf_keuangan')->group(function () {
        Route::resource('keuangan', KeuanganController::class);
        Route::resource('bagi-hasil', BagiHasilController::class);
        Route::resource('laporan', LaporanController::class);
        Route::patch('laporan/{laporan}/finalisasi', [LaporanController::class, 'finalisasi'])
             ->name('laporan.finalisasi');
    });

    /*
    |--------------------------------------------------------------
    | Administrasi — Ketua saja
    |--------------------------------------------------------------
    */
    Route::middleware('pengguna.auth:ketua')->group(function () {
        Route::resource('pengguna', PenggunaController::class);
    });
});
