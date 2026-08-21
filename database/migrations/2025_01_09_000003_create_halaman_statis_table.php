<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('halaman_statis', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('alamat_tautan')->unique();
            $table->longText('konten')->nullable();
            $table->boolean('aktif')->default(true);
            $table->waktuStandar();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('halaman_statis');
    }
};
