<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_baca', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengguna')->nullable()->constrained('pengguna')->nullOnDelete();
            $table->string('jenis_konten');
            $table->unsignedBigInteger('id_referensi');
            $table->string('alamat_ip', 45)->nullable();
            $table->timestamp('dibuat_pada')->nullable();

            $table->index(['jenis_konten', 'id_referensi']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_baca');
    }
};
