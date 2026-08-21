<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catatan_peninjauan_e_modul', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_e_modul')->constrained('e_modul')->cascadeOnDelete();
            $table->foreignId('id_pengguna')->constrained('pengguna')->cascadeOnDelete();
            $table->text('catatan');
            $table->string('keputusan');
            $table->timestamp('dibuat_pada')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catatan_peninjauan_e_modul');
    }
};
