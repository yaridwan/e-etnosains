<?php

namespace Database\Factories;

use App\Models\JenjangPendidikan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class JenjangPendidikanFactory extends Factory
{
    protected $model = JenjangPendidikan::class;

    public function definition(): array
    {
        $nama = fake()->unique()->randomElement(['SD/MI', 'SMP/MTs', 'SMA/MA', 'SMK', 'Perguruan Tinggi']);

        return [
            'nama_jenjang' => $nama,
            'alamat_tautan' => Str::slug($nama).'-'.fake()->unique()->numberBetween(1, 100000),
            'urutan' => fake()->numberBetween(1, 5),
        ];
    }
}
