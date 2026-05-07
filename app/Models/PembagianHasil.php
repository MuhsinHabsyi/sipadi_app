<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembagianHasil extends Model
{
    protected $table = 'pembagian_hasils';

    protected $fillable = [
        'id_petani',
        'musim_tanam',
        'proporsi_panen',
        'alokasi_keuntungan',
        'total_keuntungan',
    ];

    protected $casts = [
        'proporsi_panen'     => 'float',
        'alokasi_keuntungan' => 'float',
        'total_keuntungan'   => 'float',
    ];

    public function petani(): BelongsTo
    {
        return $this->belongsTo(AnggotaPetani::class, 'id_petani');
    }
}
