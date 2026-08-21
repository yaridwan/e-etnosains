<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_guru', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengguna')->unique()->constrained('pengguna')->cascadeOnDelete();
            $table->foreignId('id_instansi_pendidikan')->nullable()->constrained('instansi_pendidikan')->nullOnDelete();
            $table->string('nip_nuptk')->nullable();
            $table->string('bidang_studi')->nullable();
            $table->string('jenis_kelamin', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->text('bio')->nullable();
            $table->waktuStandar();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_guru');
    }
};
