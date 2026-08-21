<?php

namespace Database\Seeders;

use App\Models\EModul;
use App\Models\Peran;
use App\Models\Ulasan;
use Illuminate\Database\Seeder;

class UlasanSeeder extends Seeder
{
    public function run(): void
    {
        $siswa = Peran::where('nama_peran', 'siswa')->firstOrFail()->pengguna;
        $komentar = [
            'Materinya mudah dipahami dan menarik karena dikaitkan dengan budaya sekitar.',
            'Sangat membantu memahami sains lewat contoh kehidupan sehari-hari.',
            'Penjelasannya lengkap, hanya perlu lebih banyak gambar pendukung.',
            'Aktivitas observasinya seru dan menambah wawasan tentang kearifan lokal.',
        ];

        foreach (EModul::dipublikasikan()->take(6)->get() as $eModul) {
            foreach ($siswa->random(min(3, $siswa->count())) as $murid) {
                Ulasan::firstOrCreate(
                    [
                        'id_pengguna' => $murid->id,
                        'jenis_konten' => 'e_modul',
                        'id_referensi' => $eModul->id,
                    ],
                    [
                        'rating' => fake()->numberBetween(4, 5),
                        'komentar' => fake()->randomElement($komentar),
                        'status_moderasi' => 'disetujui',
                    ]
                );
            }
        }
    }
}
