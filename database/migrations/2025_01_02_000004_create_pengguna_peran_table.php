<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengguna_peran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengguna')->constrained('pengguna')->cascadeOnDelete();
            $table->foreignId('id_peran')->constrained('peran')->cascadeOnDelete();
            $table->timestamp('dibuat_pada')->nullable();

            $table->unique(['id_pengguna', 'id_peran']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengguna_peran');
    }
};
