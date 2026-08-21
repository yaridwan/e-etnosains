<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jawaban_observasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengumpulan_observasi')->constrained('pengumpulan_observasi')->cascadeOnDelete();
            $table->foreignId('id_butir_observasi')->constrained('butir_observasi')->cascadeOnDelete();
            $table->text('jawaban_teks')->nullable();
            $table->decimal('jawaban_angka', 12, 2)->nullable();
            $table->foreignId('id_opsi_butir_observasi')->nullable()->constrained('opsi_butir_observasi')->nullOnDelete();
            $table->string('berkas_jawaban')->nullable();
            $table->waktuStandar();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jawaban_observasi');
    }
};
