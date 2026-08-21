<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opsi_butir_observasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_butir_observasi')->constrained('butir_observasi')->cascadeOnDelete();
            $table->string('teks_opsi');
            $table->unsignedInteger('urutan')->default(0);
            $table->waktuStandar();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opsi_butir_observasi');
    }
};
