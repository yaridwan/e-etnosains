<?php

namespace Database\Seeders;

use App\Models\Testimoni;
use Illuminate\Database\Seeder;

class TestimoniSeeder extends Seeder
{
    public function run(): void
    {
        $testimoni = [
            ['Siti Rahayu, S.Pd.', 'Guru IPA, SMA Negeri 1 Yogyakarta', 'E-ETNOSAINS membantu saya menyusun materi yang lebih dekat dengan kehidupan siswa. Respons siswa jauh lebih antusias.'],
            ['Bambang Wijaya, M.Pd.', 'Guru Biologi, SMP Negeri 3 Surakarta', 'Fitur flipbook dan observasi sangat memudahkan pembelajaran berbasis proyek di kelas saya.'],
            ['Ahmad Fadli', 'Siswa Kelas X, SMA Negeri 5 Malang', 'Belajar jadi lebih seru karena materi dikaitkan dengan tradisi dan budaya di daerah saya sendiri.'],
        ];

        foreach ($testimoni as $urutan => [$nama, $peran, $isi]) {
            Testimoni::query()->updateOrCreate(
                ['nama' => $nama],
                ['peran_testimoni' => $peran, 'isi_testimoni' => $isi, 'rating' => 5, 'aktif' => true, 'urutan' => $urutan]
            );
        }
    }
}
