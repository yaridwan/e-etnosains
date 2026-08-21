<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('id_pengguna')->constrained('pengguna')->cascadeOnDelete();
            $table->string('tipe');
            $table->string('judul');
            $table->text('pesan');
            $table->json('data')->nullable();
            $table->timestamp('dibaca_pada')->nullable();
            $table->waktuStandar();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
