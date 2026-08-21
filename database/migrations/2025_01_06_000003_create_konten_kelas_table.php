<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konten_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kelas_belajar')->constrained('kelas_belajar')->cascadeOnDelete();
            $table->string('jenis_konten');
            $table->unsignedBigInteger('id_referensi');
            $table->unsignedInteger('urutan')->default(0);
            $table->waktuStandar();

            $table->index(['jenis_konten', 'id_referensi']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konten_kelas');
    }
};
