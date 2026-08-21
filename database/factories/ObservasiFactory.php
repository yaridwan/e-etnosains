<?php

namespace Database\Factories;

use App\Enums\StatusPublikasi;
use App\Models\Observasi;
use App\Models\Pengguna;
use Illuminate\Database\Eloquent\Factories\Factory;

class ObservasiFactory extends Factory
{
    protected $model = Observasi::class;

    public function definition(): array
    {
        return [
            'id_pengguna' => fn () => Pengguna::whereHas('peran', fn ($q) => $q->where('nama_peran', 'guru'))->inRandomOrder()->value('id') ?? Pengguna::factory(),
            'judul' => 'Observasi '.rtrim(fake()->unique()->sentence(5), '.'),
            'deskripsi' => fake()->paragraph(),
            'tujuan' => fake()->paragraph(),
            'petunjuk' => fake()->paragraph(),
            'lokasi_observasi' => fake()->city(),
            'durasi' => fake()->randomElement(['30 menit', '1 jam', '2 jam', '1 minggu']),
            'alat_dan_bahan' => fake()->sentence(),
            'prosedur' => fake()->paragraph(),
            'aspek_keselamatan' => fake()->sentence(),
            'batas_pengumpulan' => now()->addDays(fake()->numberBetween(7, 30)),
            'status_publikasi' => StatusPublikasi::Dipublikasikan,
        ];
    }
}
