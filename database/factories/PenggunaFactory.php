<?php

namespace Database\Factories;

use App\Enums\StatusAkun;
use App\Models\Pengguna;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PenggunaFactory extends Factory
{
    protected $model = Pengguna::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'nama_lengkap' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_terverifikasi_pada' => now(),
            'nomor_telepon' => '08'.fake()->numerify('##########'),
            'kata_sandi' => 'password',
            'status_akun' => StatusAkun::Aktif,
        ];
    }

    public function menungguVerifikasi(): static
    {
        return $this->state(fn () => ['status_akun' => StatusAkun::MenungguVerifikasi]);
    }
}
