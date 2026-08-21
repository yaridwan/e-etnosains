<?php

namespace Database\Factories;

use App\Enums\StatusPublikasi;
use App\Models\Observasi;
use App\Models\Pengguna;
use App\Support\JudulDemo;
use Illuminate\Database\Eloquent\Factories\Factory;

class ObservasiFactory extends Factory
{
    protected $model = Observasi::class;

    public function definition(): array
    {
        return [
            'id_pengguna' => fn () => Pengguna::whereHas('peran', fn ($q) => $q->where('nama_peran', 'guru'))->inRandomOrder()->value('id') ?? Pengguna::factory(),
            'judul' => JudulDemo::observasi(),
            'deskripsi' => JudulDemo::keterangan(),
            'tujuan' => 'Peserta didik mampu mengidentifikasi konsep sains pada objek yang diamati di lingkungan sekitar.',
            'petunjuk' => 'Lakukan pengamatan langsung, catat temuan Anda pada instrumen, lalu unggah dokumentasi pendukung.',
            'lokasi_observasi' => fake()->city(),
            'durasi' => fake()->randomElement(['30 menit', '1 jam', '2 jam', '1 minggu']),
            'alat_dan_bahan' => 'Alat tulis, kamera atau ponsel untuk dokumentasi, dan lembar pengamatan.',
            'prosedur' => '1) Tentukan objek pengamatan. 2) Catat ciri yang teramati. 3) Dokumentasikan. 4) Susun simpulan.',
            'aspek_keselamatan' => 'Utamakan keselamatan diri, mintalah izin sebelum mengamati properti milik orang lain.',
            'batas_pengumpulan' => now()->addDays(fake()->numberBetween(7, 30)),
            'status_publikasi' => StatusPublikasi::Dipublikasikan,
        ];
    }
}
