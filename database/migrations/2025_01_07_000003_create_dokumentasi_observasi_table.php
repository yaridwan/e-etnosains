<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumentasi_observasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengumpulan_observasi')->constrained('pengumpulan_observasi')->cascadeOnDelete();
            $table->string('berkas');
            $table->string('keterangan')->nullable();
            $table->timestamp('dibuat_pada')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumentasi_observasi');
    }
};
