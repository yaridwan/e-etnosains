<?php

namespace Database\Seeders;

use App\Models\KelasBelajar;
use App\Models\NilaiTugas;
use App\Models\PengumpulanTugas;
use App\Models\TugasKelas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TugasKelasSeeder extends Seeder
{
    public function run(): void
    {
        KelasBelajar::with('anggota')->get()->each(function (KelasBelajar $kelas) {
            $tugas = TugasKelas::create([
                'id_kelas_belajar' => $kelas->id,
                'id_pengguna' => $kelas->id_pengguna,
                'judul' => 'Laporan Observasi Etnosains',
                'petunjuk' => 'Kumpulkan laporan hasil observasi etnosains sesuai instruksi yang telah diberikan.',
                'tanggal_mulai' => now()->subDays(10),
                'batas_waktu' => now()->addDays(7),
                'bobot' => 100,
                'status' => 'dipublikasikan',
            ]);

            foreach ($kelas->anggota->take(3) as $siswa) {
                $pengumpulan = PengumpulanTugas::create([
                    'id_tugas_kelas' => $tugas->id,
                    'id_pengguna' => $siswa->id,
                    'berkas' => 'tugas/contoh-laporan.pdf',
                    'catatan_siswa' => 'Laporan observasi telah saya kerjakan sesuai petunjuk.',
                    'status' => 'dikirim',
                    'dikirim_pada' => now()->subDays(fake()->numberBetween(1, 5)),
                ]);

                if (fake()->boolean(70)) {
                    NilaiTugas::create([
                        'id_pengumpulan_tugas' => $pengumpulan->id,
                        'nilai' => fake()->numberBetween(75, 98),
                        'catatan_guru' => 'Kerja bagus, lengkapi dokumentasi pada laporan berikutnya.',
                        'dinilai_oleh' => $kelas->id_pengguna,
                        'dinilai_pada' => now()->subDay(),
                    ]);

                    $pengumpulan->update(['status' => 'dinilai']);
                }
            }
        });
    }
}
