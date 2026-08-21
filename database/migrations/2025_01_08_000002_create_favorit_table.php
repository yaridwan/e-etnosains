<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favorit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengguna')->constrained('pengguna')->cascadeOnDelete();
            $table->string('jenis_konten');
            $table->unsignedBigInteger('id_referensi');
            $table->timestamp('dibuat_pada')->nullable();

            $table->unique(['id_pengguna', 'jenis_konten', 'id_referensi'], 'favorit_unik');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorit');
    }
};
