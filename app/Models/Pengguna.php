<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengguna extends Model
{
    protected $table = 'penggunas';

    protected $fillable = [
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // Role constants
    const ROLE_KETUA           = 'ketua';
    const ROLE_STAF_PRODUKSI   = 'staf_produksi';
    const ROLE_STAF_PENJUALAN  = 'staf_penjualan';
    const ROLE_STAF_KEUANGAN   = 'staf_keuangan';
}
