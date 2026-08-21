<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('nama_lengkap');
            $table->string('email')->unique();
            $table->timestamp('email_terverifikasi_pada')->nullable();
            $table->string('nomor_telepon', 20)->nullable();
            $table->string('kata_sandi');
            $table->string('foto')->nullable();
            $table->string('status_akun')->default('aktif');
            $table->rememberToken('ingat_saya');
            $table->timestamp('terakhir_masuk_pada')->nullable();
            $table->string('alamat_ip_terakhir', 45)->nullable();
            $table->waktuStandar();
            $table->hapusLunak();

            $table->index('status_akun');
        });

        Schema::create('token_pengaturan_ulang_sandi', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sesi', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sesi');
        Schema::dropIfExists('token_pengaturan_ulang_sandi');
        Schema::dropIfExists('pengguna');
    }
};
