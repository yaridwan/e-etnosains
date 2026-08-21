<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peran_izin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_peran')->constrained('peran')->cascadeOnDelete();
            $table->foreignId('id_izin')->constrained('izin')->cascadeOnDelete();
            $table->timestamp('dibuat_pada')->nullable();

            $table->unique(['id_peran', 'id_izin']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peran_izin');
    }
};
