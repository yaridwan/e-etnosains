<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengumpulan_observasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_observasi')->constrained('observasi')->cascadeOnDelete();
            $table->foreignId('id_pengguna')->constrained('pengguna')->cascadeOnDelete();
            $table->string('status')->default('draf');
            $table->timestamp('dikirim_pada')->nullable();
            $table->timestamp('dinilai_pada')->nullable();
            $table->foreignId('dinilai_oleh')->nullable()->constrained('pengguna')->nullOnDelete();
            $table->unsignedInteger('skor')->nullable();
            $table->text('catatan_guru')->nullable();
            $table->waktuStandar();

            $table->unique(['id_observasi', 'id_pengguna']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumpulan_observasi');
    }
};
