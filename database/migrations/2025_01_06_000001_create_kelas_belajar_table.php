<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas_belajar', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('id_pengguna')->constrained('pengguna')->restrictOnDelete();
            $table->foreignId('id_mata_pelajaran')->constrained('mata_pelajaran')->restrictOnDelete();

            $table->string('nama_kelas');
            $table->string('kode_kelas')->unique();
            $table->string('tahun_ajaran')->nullable();
            $table->text('deskripsi')->nullable();
            $table->boolean('aktif')->default(true);

            $table->waktuStandar();
            $table->hapusLunak();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas_belajar');
    }
};
