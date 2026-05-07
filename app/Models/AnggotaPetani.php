<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AnggotaPetani extends Model
{
    protected $table = 'anggota_petanis';

    protected $fillable = [
        'nama_petani',
        'luas_lahan',
    ];

    public function alokasiBibits(): HasMany
    {
        return $this->hasMany(AlokasiBibit::class, 'id_petani');
    }

    public function dataPanens(): HasMany
    {
        return $this->hasMany(DataPanen::class, 'id_petani');
    }

    public function pembagianHasils(): HasMany
    {
        return $this->hasMany(PembagianHasil::class, 'id_petani');
    }
}
