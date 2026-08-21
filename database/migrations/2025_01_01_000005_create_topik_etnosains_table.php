<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topik_etnosains', function (Blueprint $table) {
            $table->id();
            $table->string('nama_topik');
            $table->string('alamat_tautan')->unique();
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->waktuStandar();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topik_etnosains');
    }
};
