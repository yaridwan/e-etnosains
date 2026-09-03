<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluasi', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('id_pengguna')->constrained('pengguna')->restrictOnDelete();
            $table->foreignId('id_e_modul')->nullable()->constrained('e_modul')->nullOnDelete();
            $table->foreignId('id_mata_pelajaran')->constrained('mata_pelajaran')->restrictOnDelete();
            $table->foreignId('id_jenjang_pendidikan')->constrained('jenjang_pendidikan')->restrictOnDelete();

            $table->string('judul');
            $table->string('alamat_tautan')->unique();
            $table->string('jenis_evaluasi')->default('formatif');
            $table->text('deskripsi')->nullable();
            $table->text('petunjuk')->nullable();
            $table->unsignedTinyInteger('kkm')->nullable();
            $table->unsignedInteger('durasi_menit')->nullable();

            $table->string('berkas_pdf')->nullable();
            $table->string('gambar_sampul')->nullable();
            $table->boolean('izin_unduh')->default(true);

            $table->string('status_publikasi')->default('draf');
            $table->unsignedBigInteger('jumlah_dilihat')->default(0);
            $table->unsignedBigInteger('jumlah_diunduh')->default(0);
            $table->timestamp('dipublikasikan_pada')->nullable();

            $table->waktuStandar();
            $table->hapusLunak();

            $table->index('status_publikasi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluasi');
    }
};
