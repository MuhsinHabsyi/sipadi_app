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
        Schema::create('alokasi_bibits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_petani')->constrained('anggota_petanis')->cascadeOnDelete();
            $table->string('musim_tanam'); // contoh: "2024-Ganjil"
            $table->float('jumlah_bibit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alokasi_bibits');
    }
};
