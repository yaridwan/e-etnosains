<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimoni', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('peran_testimoni')->nullable();
            $table->string('foto')->nullable();
            $table->text('isi_testimoni');
            $table->unsignedTinyInteger('rating')->default(5);
            $table->boolean('aktif')->default(true);
            $table->unsignedInteger('urutan')->default(0);
            $table->waktuStandar();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimoni');
    }
};
