<?php

namespace Database\Factories;

use App\Enums\StatusPublikasi;
use App\Models\BahanAjar;
use App\Models\JenjangPendidikan;
use App\Models\MataPelajaran;
use App\Models\Pengguna;
use Illuminate\Database\Eloquent\Factories\Factory;

class BahanAjarFactory extends Factory
{
    protected $model = BahanAjar::class;

    public function definition(): array
    {
        return [
            'id_pengguna' => fn () => Pengguna::whereHas('peran', fn ($q) => $q->where('nama_peran', 'guru'))->inRandomOrder()->value('id') ?? Pengguna::factory(),
            'id_mata_pelajaran' => fn () => MataPelajaran::inRandomOrder()->value('id') ?? MataPelajaran::factory(),
            'id_jenjang_pendidikan' => fn () => JenjangPendidikan::inRandomOrder()->value('id') ?? JenjangPendidikan::factory(),
            'judul' => rtrim(fake()->unique()->sentence(6), '.'),
            'deskripsi' => fake()->paragraph(),
            'jenis_berkas' => fake()->randomElement(['pdf', 'ppt', 'doc']),
            'status_publikasi' => StatusPublikasi::Dipublikasikan,
            'jumlah_dilihat' => fake()->numberBetween(5, 600),
            'jumlah_diunduh' => fake()->numberBetween(0, 150),
            'dipublikasikan_pada' => now()->subDays(fake()->numberBetween(1, 150)),
        ];
    }
}
