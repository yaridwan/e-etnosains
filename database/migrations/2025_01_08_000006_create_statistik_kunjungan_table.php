<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statistik_kunjungan', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('jenis_konten')->nullable();
            $table->unsignedBigInteger('id_referensi')->nullable();
            $table->string('alamat_ip', 45)->nullable();
            $table->string('agen_pengguna')->nullable();
            $table->timestamp('dibuat_pada')->nullable();

            $table->index(['jenis_konten', 'id_referensi']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistik_kunjungan');
    }
};
