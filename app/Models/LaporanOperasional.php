<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanOperasional extends Model
{
    protected $table = 'laporan_operasionals';

    protected $fillable = [
        'musim_tanam',
        'status_finalisasi',
    ];

    protected $casts = [
        'status_finalisasi' => 'boolean',
    ];
}
