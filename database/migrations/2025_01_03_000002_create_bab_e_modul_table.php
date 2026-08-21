<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bab_e_modul', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_e_modul')->constrained('e_modul')->cascadeOnDelete();
            $table->string('judul_bab');
            $table->unsignedInteger('nomor_urut')->default(0);
            $table->unsignedInteger('halaman_mulai')->nullable();
            $table->waktuStandar();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bab_e_modul');
    }
};
