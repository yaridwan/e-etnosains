<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenjang_pendidikan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jenjang');
            $table->string('alamat_tautan')->unique();
            $table->unsignedInteger('urutan')->default(0);
            $table->waktuStandar();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenjang_pendidikan');
    }
};
