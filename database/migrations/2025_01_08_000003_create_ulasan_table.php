<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengguna')->constrained('pengguna')->cascadeOnDelete();
            $table->string('jenis_konten');
            $table->unsignedBigInteger('id_referensi');
            $table->unsignedTinyInteger('rating');
            $table->text('komentar')->nullable();
            $table->string('status_moderasi')->default('menunggu');
            $table->waktuStandar();

            $table->unique(['id_pengguna', 'jenis_konten', 'id_referensi'], 'ulasan_unik');
            $table->index(['jenis_konten', 'id_referensi']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};
