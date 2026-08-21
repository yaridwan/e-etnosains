<?php

namespace Database\Seeders;

use App\Models\EModul;
use App\Models\Favorit;
use App\Models\Peran;
use Illuminate\Database\Seeder;

class FavoritSeeder extends Seeder
{
    public function run(): void
    {
        $siswa = Peran::where('nama_peran', 'siswa')->firstOrFail()->pengguna;
        $eModul = EModul::dipublikasikan()->get();

        foreach ($siswa->take(6) as $murid) {
            foreach ($eModul->random(min(2, $eModul->count())) as $konten) {
                Favorit::firstOrCreate([
                    'id_pengguna' => $murid->id,
                    'jenis_konten' => 'e_modul',
                    'id_referensi' => $konten->id,
                ]);
            }
        }
    }
}
