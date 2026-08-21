<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengguna')->nullable()->constrained('pengguna')->nullOnDelete();
            $table->string('aktivitas');
            $table->string('modul')->nullable();
            $table->unsignedBigInteger('id_referensi')->nullable();
            $table->string('alamat_ip', 45)->nullable();
            $table->string('agen_pengguna')->nullable();
            $table->json('data_sebelum')->nullable();
            $table->json('data_sesudah')->nullable();
            $table->timestamp('dibuat_pada')->nullable();

            $table->index(['modul', 'id_referensi']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_aktivitas');
    }
};
