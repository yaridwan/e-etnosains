<?php

namespace Database\Seeders;

use App\Models\EModul;
use App\Models\LogPencarian;
use App\Models\Peran;
use App\Models\RiwayatBaca;
use App\Models\RiwayatUnduhan;
use App\Models\StatistikKunjungan;
use Illuminate\Database\Seeder;

class AktivitasLogSeeder extends Seeder
{
    public function run(): void
    {
        $siswa = Peran::where('nama_peran', 'siswa')->firstOrFail()->pengguna;
        $eModul = EModul::dipublikasikan()->get();

        foreach (range(1, 40) as $i) {
            $konten = $eModul->random();
            $murid = fake()->boolean(70) ? $siswa->random() : null;

            RiwayatBaca::create([
                'id_pengguna' => $murid?->id,
                'jenis_konten' => 'e_modul',
                'id_referensi' => $konten->id,
                'alamat_ip' => fake()->ipv4(),
            ]);

            StatistikKunjungan::create([
                'url' => '/e-modul/'.$konten->alamat_tautan,
                'jenis_konten' => 'e_modul',
                'id_referensi' => $konten->id,
                'alamat_ip' => fake()->ipv4(),
                'agen_pengguna' => fake()->userAgent(),
            ]);
        }

        foreach (range(1, 20) as $i) {
            $konten = $eModul->random();
            RiwayatUnduhan::create([
                'id_pengguna' => fake()->boolean(60) ? $siswa->random()->id : null,
                'jenis_konten' => 'e_modul',
                'id_referensi' => $konten->id,
                'alamat_ip' => fake()->ipv4(),
            ]);
        }

        $kataKunci = ['gula aren', 'tanaman obat', 'ekosistem sawah', 'observasi', 'lkpd biologi', 'kearifan lokal'];
        foreach ($kataKunci as $kata) {
            LogPencarian::create([
                'id_pengguna' => fake()->boolean(50) ? $siswa->random()->id : null,
                'kata_kunci' => $kata,
                'jumlah_hasil' => fake()->numberBetween(0, 15),
            ]);
        }
    }
}
