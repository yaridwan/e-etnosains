<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_status_e_modul', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_e_modul')->constrained('e_modul')->cascadeOnDelete();
            $table->string('status_sebelum')->nullable();
            $table->string('status_sesudah');
            $table->text('catatan')->nullable();
            $table->foreignId('id_pengguna')->nullable()->constrained('pengguna')->nullOnDelete();
            $table->timestamp('dibuat_pada')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_status_e_modul');
    }
};
