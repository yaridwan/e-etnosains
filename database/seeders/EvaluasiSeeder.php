<?php

namespace Database\Seeders;

use App\Models\EModul;
use App\Models\Evaluasi;
use Illuminate\Database\Seeder;

class EvaluasiSeeder extends Seeder
{
    public function run(): void
    {
        $eModulTerbit = EModul::dipublikasikan()->get();

        foreach ($eModulTerbit->take(4) as $eModul) {
            Evaluasi::factory()->create([
                'id_pengguna' => $eModul->id_pengguna,
                'id_e_modul' => $eModul->id,
                'id_mata_pelajaran' => $eModul->id_mata_pelajaran,
                'id_jenjang_pendidikan' => $eModul->id_jenjang_pendidikan,
                'judul' => 'Evaluasi: '.$eModul->judul,
            ]);
        }

        Evaluasi::factory()->count(max(0, 6 - $eModulTerbit->take(4)->count()))->create();
    }
}
