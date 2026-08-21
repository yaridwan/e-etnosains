<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggota_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kelas_belajar')->constrained('kelas_belajar')->cascadeOnDelete();
            $table->foreignId('id_pengguna')->constrained('pengguna')->cascadeOnDelete();
            $table->timestamp('bergabung_pada')->nullable();
            $table->waktuStandar();

            $table->unique(['id_kelas_belajar', 'id_pengguna']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota_kelas');
    }
};
