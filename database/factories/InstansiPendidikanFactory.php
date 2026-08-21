<?php

namespace Database\Factories;

use App\Models\InstansiPendidikan;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstansiPendidikanFactory extends Factory
{
    protected $model = InstansiPendidikan::class;

    public function definition(): array
    {
        return [
            'nama_instansi' => fake()->unique()->company().' '.fake()->randomElement(['SD', 'SMP', 'SMA', 'SMK']),
            'jenis_instansi' => fake()->randomElement(['SD/MI', 'SMP/MTs', 'SMA/MA', 'SMK']),
            'kota' => fake()->city(),
            'provinsi' => fake()->randomElement(['Jawa Tengah', 'Jawa Barat', 'D.I. Yogyakarta', 'Bali']),
        ];
    }
}
