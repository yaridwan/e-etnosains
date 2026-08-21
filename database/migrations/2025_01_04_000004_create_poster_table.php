<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('poster', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('id_pengguna')->constrained('pengguna')->restrictOnDelete();
            $table->foreignId('id_e_modul')->nullable()->constrained('e_modul')->nullOnDelete();

            $table->string('judul');
            $table->string('alamat_tautan')->unique();
            $table->text('deskripsi')->nullable();
            $table->string('gambar');

            $table->string('status_publikasi')->default('draf');
            $table->unsignedBigInteger('jumlah_dilihat')->default(0);
            $table->timestamp('dipublikasikan_pada')->nullable();

            $table->waktuStandar();
            $table->hapusLunak();

            $table->index('status_publikasi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('poster');
    }
};
