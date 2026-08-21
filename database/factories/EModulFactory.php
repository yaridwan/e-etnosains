<?php

namespace Database\Factories;

use App\Enums\StatusPublikasi;
use App\Models\EModul;
use App\Models\JenjangPendidikan;
use App\Models\MataPelajaran;
use App\Models\Pengguna;
use App\Models\TopikEtnosains;
use App\Support\JudulDemo;
use App\Support\PembuatPosterDemo;
use Illuminate\Database\Eloquent\Factories\Factory;

class EModulFactory extends Factory
{
    protected $model = EModul::class;

    public function definition(): array
    {
        $judul = JudulDemo::eModul();

        return [
            'id_pengguna' => fn () => Pengguna::whereHas('peran', fn ($q) => $q->where('nama_peran', 'guru'))->inRandomOrder()->value('id') ?? Pengguna::factory(),
            'id_jenjang_pendidikan' => fn () => JenjangPendidikan::inRandomOrder()->value('id') ?? JenjangPendidikan::factory(),
            'id_mata_pelajaran' => fn () => MataPelajaran::inRandomOrder()->value('id') ?? MataPelajaran::factory(),
            'id_topik_etnosains' => fn () => TopikEtnosains::inRandomOrder()->value('id'),
            'judul' => $judul,
            'gambar_sampul' => PembuatPosterDemo::sampul($judul),
            'ringkasan' => JudulDemo::keterangan(),
            'deskripsi' => JudulDemo::keterangan().' '.JudulDemo::keterangan(),
            'capaian_pembelajaran' => 'Peserta didik mampu menjelaskan konsep sains yang terkandung dalam praktik kearifan lokal setempat.',
            'tujuan_pembelajaran' => 'Menghubungkan fenomena budaya dengan konsep sains serta menumbuhkan apresiasi terhadap kearifan lokal.',
            'kelas' => fake()->randomElement(['VII', 'VIII', 'IX', 'X', 'XI', 'XII']),
            'fase' => fake()->randomElement(['D', 'E', 'F']),
            'tahun' => now()->year,
            'kata_kunci' => 'etnosains, kearifan lokal, pembelajaran sains',
            'izin_unduh' => fake()->boolean(80),
            'pengetahuan_lokal' => 'Praktik kearifan lokal yang diwariskan turun-temurun oleh masyarakat setempat.',
            'konsep_sains' => 'Konsep sains yang relevan dengan praktik kearifan lokal yang dikaji pada materi ini.',
            'konteks_wilayah' => fake()->city(),
            'aktivitas_saintifik' => 'Peserta didik melakukan pengamatan langsung lalu menghubungkannya dengan konsep sains.',
            'nilai_karakter' => 'Ketekunan, gotong royong, dan kepedulian terhadap pelestarian budaya.',
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
