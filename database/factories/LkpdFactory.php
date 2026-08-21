<?php

namespace Database\Factories;

use App\Enums\StatusPublikasi;
use App\Models\JenjangPendidikan;
use App\Models\Lkpd;
use App\Models\MataPelajaran;
use App\Models\Pengguna;
use Illuminate\Database\Eloquent\Factories\Factory;

class LkpdFactory extends Factory
{
    protected $model = Lkpd::class;

    public function definition(): array
    {
        return [
            'id_pengguna' => fn () => Pengguna::whereHas('peran', fn ($q) => $q->where('nama_peran', 'guru'))->inRandomOrder()->value('id') ?? Pengguna::factory(),
            'id_mata_pelajaran' => fn () => MataPelajaran::inRandomOrder()->value('id') ?? MataPelajaran::factory(),
            'id_jenjang_pendidikan' => fn () => JenjangPendidikan::inRandomOrder()->value('id') ?? JenjangPendidikan::factory(),
            'judul' => 'LKPD '.rtrim(fake()->unique()->sentence(5), '.'),
            'deskripsi' => fake()->paragraph(),
            'petunjuk' => fake()->paragraph(),
            'jenis' => 'digital',
            'tujuan' => fake()->paragraph(),
            'aktivitas' => fake()->paragraph(),
            'pertanyaan' => fake()->paragraph(),
            'kesimpulan' => fake()->sentence(),
            'izin_unduh' => true,
            'status_publikasi' => StatusPublikasi::Dipublikasikan,
            'jumlah_dilihat' => fake()->numberBetween(5, 800),
            'jumlah_diunduh' => fake()->numberBetween(0, 200),
            'dipublikasikan_pada' => now()->subDays(fake()->numberBetween(1, 150)),
        ];
    }
}
