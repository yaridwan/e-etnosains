<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('e_modul', function (Blueprint $table) {
            // Waktu terbit otomatis. Diisi saat Administrator menyetujui E-Modul
            // dengan opsi "jadwalkan", dikosongkan lagi begitu benar-benar terbit.
            $table->timestamp('dijadwalkan_pada')->nullable()->after('dipublikasikan_pada');
            $table->index('dijadwalkan_pada');
        });
    }

    public function down(): void
    {
        Schema::table('e_modul', function (Blueprint $table) {
            $table->dropIndex(['dijadwalkan_pada']);
            $table->dropColumn('dijadwalkan_pada');
        });
    }
};
