<?php

namespace Database\Seeders;

use App\Models\EModul;
use App\Models\Lkpd;
use Illuminate\Database\Seeder;

class LkpdSeeder extends Seeder
{
    public function run(): void
    {
        $eModulTerbit = EModul::dipublikasikan()->get();

        foreach ($eModulTerbit as $eModul) {
            Lkpd::factory()->create([
                'id_pengguna' => $eModul->id_pengguna,
                'id_e_modul' => $eModul->id,
                'id_mata_pelajaran' => $eModul->id_mata_pelajaran,
                'id_jenjang_pendidikan' => $eModul->id_jenjang_pendidikan,
                'judul' => 'LKPD: '.$eModul->judul,
                'tujuan' => $eModul->tujuan_pembelajaran,
            ]);
        }

        Lkpd::factory()->count(max(0, 6 - $eModulTerbit->count()))->create();
    }
}
