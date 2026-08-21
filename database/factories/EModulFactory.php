<?php

namespace Database\Factories;

use App\Enums\StatusPublikasi;
use App\Models\EModul;
use App\Models\JenjangPendidikan;
use App\Models\MataPelajaran;
use App\Models\Pengguna;
use App\Models\TopikEtnosains;
use Illuminate\Database\Eloquent\Factories\Factory;

class EModulFactory extends Factory
{
    protected $model = EModul::class;

    public function definition(): array
    {
        $judul = fake()->unique()->sentence(6);

        return [
            'id_pengguna' => fn () => Pengguna::whereHas('peran', fn ($q) => $q->where('nama_peran', 'guru'))->inRandomOrder()->value('id') ?? Pengguna::factory(),
            'id_jenjang_pendidikan' => fn () => JenjangPendidikan::inRandomOrder()->value('id') ?? JenjangPendidikan::factory(),
            'id_mata_pelajaran' => fn () => MataPelajaran::inRandomOrder()->value('id') ?? MataPelajaran::factory(),
            'id_topik_etnosains' => fn () => TopikEtnosains::inRandomOrder()->value('id'),
            'judul' => rtrim($judul, '.'),
            'ringkasan' => fake()->paragraph(),
            'deskripsi' => fake()->paragraphs(3, true),
            'capaian_pembelajaran' => fake()->paragraph(),
            'tujuan_pembelajaran' => fake()->paragraph(),
            'kelas' => fake()->randomElement(['VII', 'VIII', 'IX', 'X', 'XI', 'XII']),
            'fase' => fake()->randomElement(['D', 'E', 'F']),
            'tahun' => now()->year,
            'kata_kunci' => implode(', ', fake()->words(5)),
            'izin_unduh' => fake()->boolean(80),
            'pengetahuan_lokal' => fake()->paragraph(),
            'konsep_sains' => fake()->paragraph(),
            'konteks_wilayah' => fake()->city(),
            'aktivitas_saintifik' => fake()->paragraph(),
            'nilai_karakter' => fake()->sentence(),
            'status_publikasi' => StatusPublikasi::Dipublikasikan,
            'unggulan' => fake()->boolean(20),
            'jumlah_dilihat' => fake()->numberBetween(10, 2000),
            'jumlah_diunduh' => fake()->numberBetween(0, 500),
            'dipublikasikan_pada' => now()->subDays(fake()->numberBetween(1, 200)),
        ];
    }

    public function draf(): static
    {
        return $this->state(fn () => [
            'status_publikasi' => StatusPublikasi::Draf,
            'dipublikasikan_pada' => null,
        ]);
    }

    public function diajukan(): static
    {
        return $this->state(fn () => [
            'status_publikasi' => StatusPublikasi::Diajukan,
            'dipublikasikan_pada' => null,
        ]);
    }
}
