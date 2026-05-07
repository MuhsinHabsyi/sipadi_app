<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembagian_hasils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_petani')->constrained('anggota_petanis')->cascadeOnDelete();
            $table->string('musim_tanam');
            $table->float('proporsi_panen');   // persentase kontribusi panen petani
            $table->float('alokasi_keuntungan'); // nominal rupiah yang diterima petani
            $table->float('total_keuntungan');   // total keuntungan kelompok periode tersebut
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembagian_hasils');
    }
};
