<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Setiap kali E-Modul terbit (baik langsung disetujui maupun lewat
        // penjadwalan), seluruh isinya saat itu dibekukan ke sini. Baris di
        // tabel ini tidak pernah diubah atau dihapus, hanya ditambah, sehingga
        // riwayat versi selalu bisa ditelusuri kembali.
        Schema::create('versi_e_modul', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_e_modul')->constrained('e_modul')->cascadeOnDelete();
            $table->unsignedInteger('nomor_versi');

            $table->string('judul');
            $table->text('ringkasan')->nullable();
            $table->longText('deskripsi')->nullable();
            $table->text('capaian_pembelajaran')->nullable();
            $table->text('tujuan_pembelajaran')->nullable();
            $table->text('pengetahuan_lokal')->nullable();
            $table->text('konsep_sains')->nullable();
            $table->string('konteks_wilayah')->nullable();
            $table->text('aktivitas_saintifik')->nullable();
            $table->text('nilai_karakter')->nullable();
            $table->string('gambar_sampul')->nullable();
            $table->string('gambar_poster')->nullable();
            $table->string('berkas_pdf')->nullable();
            $table->unsignedInteger('jumlah_halaman')->nullable();

            $table->foreignId('id_pengguna')->nullable()->comment('Administrator yang menerbitkan versi ini')->constrained('pengguna')->nullOnDelete();
            $table->timestamp('dibuat_pada')->nullable();

            $table->unique(['id_e_modul', 'nomor_versi']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('versi_e_modul');
    }
};
