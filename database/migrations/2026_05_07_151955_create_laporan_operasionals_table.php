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
        Schema::create('laporan_operasionals', function (Blueprint $table) {
            $table->id();
            $table->string('musim_tanam');
            $table->boolean('status_finalisasi')->default(false); // false = draft, true = final
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_operasionals');
    }
};
