<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan_aplikasi', function (Blueprint $table) {
            $table->id();
            $table->string('kelompok')->index();
            $table->string('kunci')->unique();
            $table->text('nilai')->nullable();
            $table->string('tipe')->default('teks');
            $table->string('keterangan')->nullable();
            $table->boolean('dapat_diubah')->default(true);
            $table->waktuStandar();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_aplikasi');
    }
};
