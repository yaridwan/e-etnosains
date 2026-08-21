<?php

namespace Database\Seeders;

use App\Models\EModul;
use App\Models\KelasBelajar;
use App\Models\Lkpd;
use App\Models\Observasi;
use App\Models\Peran;
use Illuminate\Database\Seeder;

class KelasBelajarSeeder extends Seeder
{
    public function run(): void
    {
        $guru = Peran::where('nama_peran', 'guru')->firstOrFail()->pengguna;
        $siswa = Peran::where('nama_peran', 'siswa')->firstOrFail()->pengguna;

        $namaKelas = ['BIOLOGI X-A', 'IPA VIII-B', 'KIMIA XI-A'];

        foreach ($namaKelas as $i => $nama) {
            $penulis = $guru[$i % $guru->count()];

            $kelas = KelasBelajar::create([
                'id_pengguna' => $penulis->id,
                'id_mata_pelajaran' => $penulis->eModul()->first()?->id_mata_pelajaran ?? 1,
                'nama_kelas' => $nama,
                'kode_kelas' => 'ETNO-'.strtoupper(substr(md5($nama), 0, 6)),
                'tahun_ajaran' => now()->year.'/'.(now()->year + 1),
                'deskripsi' => "Kelas belajar {$nama} untuk pembelajaran berbasis etnosains.",
                'aktif' => true,
            ]);

            $anggota = $siswa->slice($i * 4, 5);
            foreach ($anggota as $murid) {
                $kelas->anggota()->attach($murid->id, ['bergabung_pada' => now()->subDays(fake()->numberBetween(5, 60))]);
            }

            $eModul = EModul::dipublikasikan()->inRandomOrder()->first();
            if ($eModul) {
                $kelas->kontenKelas()->create([
                    'jenis_konten' => 'e_modul',
                    'id_referensi' => $eModul->id,
                    'urutan' => 1,
                ]);
            }

            $lkpd = Lkpd::inRandomOrder()->first();
            if ($lkpd) {
                $kelas->kontenKelas()->create([
                    'jenis_konten' => 'lkpd',
                    'id_referensi' => $lkpd->id,
                    'urutan' => 2,
                ]);
            }

            $observasi = Observasi::inRandomOrder()->first();
            if ($observasi) {
                $kelas->kontenKelas()->create([
                    'jenis_konten' => 'observasi',
                    'id_referensi' => $observasi->id,
                    'urutan' => 3,
                ]);
            }
        }
    }
}
