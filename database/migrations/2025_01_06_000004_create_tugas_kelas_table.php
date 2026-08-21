<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tugas_kelas', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('id_kelas_belajar')->constrained('kelas_belajar')->cascadeOnDelete();
            $table->foreignId('id_pengguna')->constrained('pengguna')->restrictOnDelete();

            $table->string('judul');
            $table->text('petunjuk')->nullable();
            $table->string('berkas')->nullable();
            $table->string('jenis_referensi')->nullable();
            $table->unsignedBigInteger('id_referensi_konten')->nullable();

            $table->timestamp('tanggal_mulai')->nullable();
            $table->timestamp('batas_waktu')->nullable();
            $table->unsignedInteger('bobot')->default(100);
            $table->string('status')->default('draf');

            $table->waktuStandar();
            $table->hapusLunak();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tugas_kelas');
    }
};
