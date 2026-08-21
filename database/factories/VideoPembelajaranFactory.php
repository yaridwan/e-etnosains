<?php

namespace Database\Factories;

use App\Enums\StatusPublikasi;
use App\Models\MataPelajaran;
use App\Models\Pengguna;
use App\Models\VideoPembelajaran;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoPembelajaranFactory extends Factory
{
    protected $model = VideoPembelajaran::class;

    public function definition(): array
    {
        $idYoutube = fake()->regexify('[A-Za-z0-9_-]{11}');

        return [
            'id_pengguna' => fn () => Pengguna::whereHas('peran', fn ($q) => $q->where('nama_peran', 'guru'))->inRandomOrder()->value('id') ?? Pengguna::factory(),
            'id_mata_pelajaran' => fn () => MataPelajaran::inRandomOrder()->value('id') ?? MataPelajaran::factory(),
            'judul' => rtrim(fake()->unique()->sentence(6), '.'),
            'deskripsi' => fake()->paragraph(),
            'url_video' => "https://www.youtube.com/watch?v={$idYoutube}",
            'id_youtube' => $idYoutube,
            'status_publikasi' => StatusPublikasi::Dipublikasikan,
            'jumlah_dilihat' => fake()->numberBetween(10, 3000),
            'dipublikasikan_pada' => now()->subDays(fake()->numberBetween(1, 150)),
        ];
    }
}
