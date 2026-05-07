<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->string('jenis_beras')->after('id_pelanggan');
            $table->decimal('harga_satuan', 12, 0)->after('jenis_beras');
            $table->decimal('total_harga', 12, 0)->after('jumlah_pesanan');
            $table->string('bukti_transfer')->nullable()->after('total_harga');
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['jenis_beras', 'harga_satuan', 'total_harga', 'bukti_transfer']);
        });
    }
};
