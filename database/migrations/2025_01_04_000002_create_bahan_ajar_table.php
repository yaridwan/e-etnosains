<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bahan_ajar', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('id_pengguna')->constrained('pengguna')->restrictOnDelete();
            $table->foreignId('id_mata_pelajaran')->constrained('mata_pelajaran')->restrictOnDelete();
            $table->foreignId('id_jenjang_pendidikan')->constrained('jenjang_pendidikan')->restrictOnDelete();
            $table->foreignId('id_topik_etnosains')->nullable()->constrained('topik_etnosains')->nullOnDelete();

            $table->string('judul');
            $table->string('alamat_tautan')->unique();
            $table->text('deskripsi')->nullable();
            $table->string('jenis_berkas')->default('pdf');
            $table->string('berkas')->nullable();
            $table->string('gambar_sampul')->nullable();
            $table->string('tautan_eksternal')->nullable();

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
        Schema::dropIfExists('bahan_ajar');
    }
};
