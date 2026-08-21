<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konten_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tag')->constrained('tag')->cascadeOnDelete();
            $table->string('jenis_konten');
            $table->unsignedBigInteger('id_referensi');

            $table->unique(['id_tag', 'jenis_konten', 'id_referensi'], 'konten_tag_unik');
            $table->index(['jenis_konten', 'id_referensi']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konten_tag');
    }
};
