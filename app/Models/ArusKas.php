<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArusKas extends Model
{
    protected $table = 'arus_kas';

    protected $fillable = [
        'tanggal',
        'musim_tanam',
        'jenis_transaksi',
        'nominal',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'nominal' => 'float',
    ];

    // Jenis transaksi constants
    const JENIS_PEMASUKAN   = 'pemasukan';
    const JENIS_PENGELUARAN = 'pengeluaran';
}
