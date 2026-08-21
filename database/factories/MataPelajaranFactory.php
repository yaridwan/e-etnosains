<?php

namespace Database\Factories;

use App\Models\MataPelajaran;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MataPelajaranFactory extends Factory
{
    protected $model = MataPelajaran::class;

    public function definition(): array
    {
        $nama = fake()->unique()->words(2, true);

        return [
            'nama_mata_pelajaran' => ucwords($nama),
            'alamat_tautan' => Str::slug($nama),
        ];
    }
}
