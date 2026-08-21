<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_navigasi', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('tautan');
            $table->unsignedInteger('urutan')->default(0);
            $table->foreignId('induk_id')->nullable()->constrained('menu_navigasi')->cascadeOnDelete();
            $table->boolean('aktif')->default(true);
            $table->waktuStandar();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_navigasi');
    }
};
