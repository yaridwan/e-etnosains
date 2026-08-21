<?php

namespace Database\Factories;

use App\Enums\StatusPublikasi;
use App\Models\Pengguna;
use App\Models\Poster;
use Illuminate\Database\Eloquent\Factories\Factory;

class PosterFactory extends Factory
{
    protected $model = Poster::class;

    public function definition(): array
    {
        return [
            'id_pengguna' => fn () => Pengguna::whereHas('peran', fn ($q) => $q->where('nama_peran', 'guru'))->inRandomOrder()->value('id') ?? Pengguna::factory(),
            'judul' => rtrim(fake()->unique()->sentence(5), '.'),
            'deskripsi' => fake()->paragraph(),
            'gambar' => 'poster/placeholder.svg',
            'status_publikasi' => StatusPublikasi::Dipublikasikan,
            'jumlah_dilihat' => fake()->numberBetween(5, 500),
            'dipublikasikan_pada' => now()->subDays(fake()->numberBetween(1, 150)),
        ];
    }
}
