<?php

namespace Database\Seeders;

use App\Models\EModul;
use App\Models\KemajuanBelajar;
use App\Models\Peran;
use Illuminate\Database\Seeder;

class KemajuanBelajarSeeder extends Seeder
{
    public function run(): void
    {
        $siswa = Peran::where('nama_peran', 'siswa')->firstOrFail()->pengguna;
        $eModul = EModul::dipublikasikan()->get();

        foreach ($siswa->take(8) as $murid) {
            foreach ($eModul->random(min(3, $eModul->count())) as $konten) {
                $persentase = fake()->numberBetween(10, 100);

                KemajuanBelajar::create([
                    'id_pengguna' => $murid->id,
                    'jenis_konten' => 'e_modul',
                    'id_referensi' => $konten->id,
                    'halaman_terakhir' => (int) ceil(($persentase / 100) * ($konten->jumlah_halaman ?: 20)),
                    'persentase_baca' => $persentase,
                    'status' => $persentase >= 100 ? 'selesai' : 'mulai',
                    'terakhir_diakses_pada' => now()->subDays(fake()->numberBetween(0, 20)),
                ]);
            }
        }
    }
}
