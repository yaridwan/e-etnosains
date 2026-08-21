<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengumpulan_tugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tugas_kelas')->constrained('tugas_kelas')->cascadeOnDelete();
            $table->foreignId('id_pengguna')->constrained('pengguna')->cascadeOnDelete();
            $table->string('berkas')->nullable();
            $table->text('catatan_siswa')->nullable();
            $table->string('status')->default('dikirim');
            $table->timestamp('dikirim_pada')->nullable();
            $table->waktuStandar();

            $table->unique(['id_tugas_kelas', 'id_pengguna']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumpulan_tugas');
    }
};
