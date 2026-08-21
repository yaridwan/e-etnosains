<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai_tugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengumpulan_tugas')->unique()->constrained('pengumpulan_tugas')->cascadeOnDelete();
            $table->decimal('nilai', 5, 2);
            $table->text('catatan_guru')->nullable();
            $table->foreignId('dinilai_oleh')->constrained('pengguna')->restrictOnDelete();
            $table->timestamp('dinilai_pada')->nullable();
            $table->waktuStandar();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_tugas');
    }
};
