<?php

namespace Database\Seeders;

use App\Models\EModul;
use App\Models\VideoPembelajaran;
use Illuminate\Database\Seeder;

class VideoPembelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $eModulTerbit = EModul::dipublikasikan()->take(3)->get();

        foreach ($eModulTerbit as $eModul) {
            VideoPembelajaran::factory()->create([
                'id_pengguna' => $eModul->id_pengguna,
                'id_e_modul' => $eModul->id,
                'id_mata_pelajaran' => $eModul->id_mata_pelajaran,
                'id_topik_etnosains' => $eModul->id_topik_etnosains,
                'judul' => 'Video Pembelajaran: '.$eModul->judul,
            ]);
        }

        VideoPembelajaran::factory()->count(3)->create();
    }
}
