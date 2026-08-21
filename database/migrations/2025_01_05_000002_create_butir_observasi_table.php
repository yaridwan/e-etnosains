<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('butir_observasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_observasi')->constrained('observasi')->cascadeOnDelete();
            $table->text('pertanyaan');
            $table->text('petunjuk')->nullable();
            $table->string('tipe_pertanyaan');
            $table->boolean('wajib')->default(true);
            $table->unsignedInteger('urutan')->default(0);
            $table->unsignedInteger('skor_maksimal')->nullable();
            $table->waktuStandar();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('butir_observasi');
    }
};
