<?php

namespace Database\Seeders;

use App\Models\EModul;
use App\Models\Poster;
use Illuminate\Database\Seeder;

class PosterSeeder extends Seeder
{
    public function run(): void
    {
        $eModulTerbit = EModul::dipublikasikan()->get();

        foreach ($eModulTerbit as $eModul) {
            Poster::factory()->create([
                'id_pengguna' => $eModul->id_pengguna,
                'id_e_modul' => $eModul->id,
                'judul' => 'Poster: '.$eModul->judul,
            ]);
        }

        Poster::factory()->count(max(0, 6 - $eModulTerbit->count()))->create();
    }
}
