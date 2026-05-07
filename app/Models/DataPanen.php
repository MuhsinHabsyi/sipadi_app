<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataPanen extends Model
{
    protected $table = 'data_panens';

    protected $fillable = [
        'id_petani',
        'musim_tanam',
        'total_panen',
    ];

    public function petani(): BelongsTo
    {
        return $this->belongsTo(AnggotaPetani::class, 'id_petani');
    }
}
