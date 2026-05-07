<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlokasiBibit extends Model
{
    protected $table = 'alokasi_bibits';

    protected $fillable = [
        'id_petani',
        'musim_tanam',
        'jumlah_bibit',
    ];

    public function petani(): BelongsTo
    {
        return $this->belongsTo(AnggotaPetani::class, 'id_petani');
    }
}
