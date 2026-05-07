<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    protected $table = 'transaksis';

    protected $fillable = [
        'id_pelanggan',
        'tanggal_pesanan',
        'jumlah_pesanan',
        'status_pesanan',
    ];

    protected $casts = [
        'tanggal_pesanan' => 'date',
    ];

    // Status constants
    const STATUS_MENUNGGU   = 'Menunggu';
    const STATUS_SELESAI    = 'Selesai';
    const STATUS_DIBATALKAN = 'Dibatalkan';

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }
}
