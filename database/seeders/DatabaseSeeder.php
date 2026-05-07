<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use App\Models\StokBeras;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun default Ketua
        Pengguna::firstOrCreate(
            ['username' => 'ketua'],
            [
                'password' => Hash::make('ketua123'),
                'role'     => 'ketua',
            ]
        );

        // Akun demo staf
        Pengguna::firstOrCreate(
            ['username' => 'staf_produksi'],
            ['password' => Hash::make('produksi123'), 'role' => 'staf_produksi']
        );
        Pengguna::firstOrCreate(
            ['username' => 'staf_penjualan'],
            ['password' => Hash::make('penjualan123'), 'role' => 'staf_penjualan']
        );
        Pengguna::firstOrCreate(
            ['username' => 'staf_keuangan'],
            ['password' => Hash::make('keuangan123'), 'role' => 'staf_keuangan']
        );

        // Inisialisasi stok beras (1 record)
        if (StokBeras::count() === 0) {
            StokBeras::create(['ketersediaan_stok' => 0]);
        }
    }
}
