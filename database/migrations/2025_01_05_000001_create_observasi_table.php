<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('observasi', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('id_pengguna')->constrained('pengguna')->restrictOnDelete();
            $table->foreignId('id_e_modul')->nullable()->constrained('e_modul')->nullOnDelete();
            $table->foreignId('id_lkpd')->nullable()->constrained('lkpd')->nullOnDelete();

            $table->string('judul');
            $table->string('alamat_tautan')->unique();
            $table->text('deskripsi')->nullable();
            $table->text('tujuan')->nullable();
            $table->text('petunjuk')->nullable();
            $table->string('lokasi_observasi')->nullable();
            $table->string('durasi')->nullable();
            $table->text('alat_dan_bahan')->nullable();
            $table->text('prosedur')->nullable();
            $table->text('aspek_keselamatan')->nullable();

            $table->timestamp('batas_pengumpulan')->nullable();
            $table->string('status_publikasi')->default('draf');

            $table->waktuStandar();
            $table->hapusLunak();

            $table->index('status_publikasi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('observasi');
    }
};
