<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Model
{
    protected $table = 'pelanggans';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'kontak',
        'telepon',
        'alamat',
    ];

    protected $hidden = [
        'password',
    ];

    public function transaksis(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'id_pelanggan');
    }
}
