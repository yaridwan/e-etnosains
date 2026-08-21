<?php

namespace Database\Factories;

use App\Models\KelasBelajar;
use App\Models\MataPelajaran;
use App\Models\Pengguna;
use Illuminate\Database\Eloquent\Factories\Factory;

class KelasBelajarFactory extends Factory
{
    protected $model = KelasBelajar::class;

    public function definition(): array
    {
        return [
            'id_pengguna' => fn () => Pengguna::whereHas('peran', fn ($q) => $q->where('nama_peran', 'guru'))->inRandomOrder()->value('id') ?? Pengguna::factory(),
            'id_mata_pelajaran' => fn () => MataPelajaran::inRandomOrder()->value('id') ?? MataPelajaran::factory(),
            'nama_kelas' => fake()->randomElement(['VII', 'VIII', 'IX', 'X', 'XI', 'XII']).' '.fake()->randomElement(['A', 'B', 'C']),
            'tahun_ajaran' => now()->year.'/'.(now()->year + 1),
            'deskripsi' => fake()->sentence(),
            'aktif' => true,
        ];
    }
}
