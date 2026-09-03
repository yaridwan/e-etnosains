<?php

namespace Database\Factories;

use App\Enums\StatusPublikasi;
use App\Models\Evaluasi;
use App\Models\JenjangPendidikan;
use App\Models\MataPelajaran;
use App\Models\Pengguna;
use App\Support\JudulDemo;
use Illuminate\Database\Eloquent\Factories\Factory;

class EvaluasiFactory extends Factory
{
    protected $model = Evaluasi::class;

    public function definition(): array
    {
        return [
            'id_pengguna' => fn () => Pengguna::whereHas('peran', fn ($q) => $q->where('nama_peran', 'guru'))->inRandomOrder()->value('id') ?? Pengguna::factory(),
            'id_mata_pelajaran' => fn () => MataPelajaran::inRandomOrder()->value('id') ?? MataPelajaran::factory(),
            'id_jenjang_pendidikan' => fn () => JenjangPendidikan::inRandomOrder()->value('id') ?? JenjangPendidikan::factory(),
            'judul' => JudulDemo::evaluasi(),
            'jenis_evaluasi' => fake()->randomElement(array_keys(Evaluasi::jenisEvaluasi())),
            'deskripsi' => JudulDemo::keterangan(),
            'petunjuk' => 'Kerjakan seluruh soal berikut secara mandiri, tuliskan jawaban pada lembar yang telah disediakan.',
            'kkm' => fake()->randomElement([70, 72, 75, 78, 80]),
            'durasi_menit' => fake()->randomElement([45, 60, 90, 120]),
            'izin_unduh' => true,
            'status_publikasi' => StatusPublikasi::Dipublikasikan,
            'jumlah_dilihat' => fake()->numberBetween(5, 600),
            'jumlah_diunduh' => fake()->numberBetween(0, 150),
            'dipublikasikan_pada' => now()->subDays(fake()->numberBetween(1, 150)),
        ];
    }
}
