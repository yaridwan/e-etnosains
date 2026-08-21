<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kemajuan_belajar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengguna')->constrained('pengguna')->cascadeOnDelete();
            $table->string('jenis_konten');
            $table->unsignedBigInteger('id_referensi');
            $table->unsignedInteger('halaman_terakhir')->default(0);
            $table->unsignedTinyInteger('persentase_baca')->default(0);
            $table->string('status')->default('mulai');
            $table->timestamp('terakhir_diakses_pada')->nullable();
            $table->waktuStandar();

            $table->unique(['id_pengguna', 'jenis_konten', 'id_referensi'], 'kemajuan_unik');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kemajuan_belajar');
    }
};
