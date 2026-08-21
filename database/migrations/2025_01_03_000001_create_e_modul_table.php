<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('e_modul', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('id_pengguna')->constrained('pengguna')->restrictOnDelete();
            $table->foreignId('id_jenjang_pendidikan')->constrained('jenjang_pendidikan')->restrictOnDelete();
            $table->foreignId('id_mata_pelajaran')->constrained('mata_pelajaran')->restrictOnDelete();
            $table->foreignId('id_topik_etnosains')->nullable()->constrained('topik_etnosains')->nullOnDelete();
            $table->foreignId('id_daerah_etnosains')->nullable()->constrained('daerah_etnosains')->nullOnDelete();

            $table->string('judul');
            $table->string('alamat_tautan')->unique();
            $table->text('ringkasan')->nullable();
            $table->longText('deskripsi')->nullable();

            $table->text('capaian_pembelajaran')->nullable();
            $table->text('tujuan_pembelajaran')->nullable();

            $table->string('kelas', 20)->nullable();
            $table->string('fase', 10)->nullable();
            $table->unsignedSmallInteger('tahun')->nullable();
            $table->string('kata_kunci')->nullable();

            $table->string('gambar_sampul')->nullable();
            $table->string('gambar_poster')->nullable();
            $table->string('berkas_pdf')->nullable();
            $table->unsignedInteger('jumlah_halaman')->nullable();
            $table->boolean('izin_unduh')->default(false);

            // Muatan khas etnosains
            $table->text('pengetahuan_lokal')->nullable();
            $table->text('konsep_sains')->nullable();
            $table->string('konteks_wilayah')->nullable();
            $table->text('aktivitas_saintifik')->nullable();
            $table->text('nilai_karakter')->nullable();

            $table->string('status_publikasi')->default('draf');
            $table->boolean('unggulan')->default(false);
            $table->unsignedBigInteger('jumlah_dilihat')->default(0);
            $table->unsignedBigInteger('jumlah_diunduh')->default(0);
            $table->text('catatan_reviewer')->nullable();
            $table->timestamp('dipublikasikan_pada')->nullable();

            $table->waktuStandar();
            $table->hapusLunak();

            $table->index('status_publikasi');
            $table->index('dipublikasikan_pada');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('e_modul');
    }
};
