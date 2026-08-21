<?php

namespace Database\Factories;

use App\Enums\StatusPublikasi;
use App\Models\JenjangPendidikan;
use App\Models\Lkpd;
use App\Models\MataPelajaran;
use App\Models\Pengguna;
use App\Support\JudulDemo;
use Illuminate\Database\Eloquent\Factories\Factory;

class LkpdFactory extends Factory
{
    protected $model = Lkpd::class;

    public function definition(): array
    {
        return [
            'id_pengguna' => fn () => Pengguna::whereHas('peran', fn ($q) => $q->where('nama_peran', 'guru'))->inRandomOrder()->value('id') ?? Pengguna::factory(),
            'id_mata_pelajaran' => fn () => MataPelajaran::inRandomOrder()->value('id') ?? MataPelajaran::factory(),
            'id_jenjang_pendidikan' => fn () => JenjangPendidikan::inRandomOrder()->value('id') ?? JenjangPendidikan::factory(),
            'judul' => JudulDemo::lkpd(),
            'deskripsi' => JudulDemo::keterangan(),
            'petunjuk' => 'Bacalah seluruh langkah kegiatan sebelum mulai mengerjakan, lalu catat setiap hasil pengamatan Anda.',
            'jenis' => 'digital',
            'tujuan' => 'Peserta didik mampu menghubungkan hasil pengamatan dengan konsep sains yang telah dipelajari.',
            'aktivitas' => 'Lakukan pengamatan di lingkungan sekitar, catat data yang ditemukan, lalu diskusikan bersama kelompok.',
            'pertanyaan' => 'Konsep sains apa yang Anda temukan pada praktik kearifan lokal tersebut? Jelaskan disertai bukti pengamatan.',
            'kesimpulan' => 'Tuliskan simpulan Anda mengenai hubungan antara kearifan lokal dan konsep sains yang dipelajari.',
            'izin_unduh' => true,
            'status_publikasi' => StatusPublikasi::Dipublikasikan,
            'jumlah_dilihat' => fake()->numberBetween(5, 800),
            'jumlah_diunduh' => fake()->numberBetween(0, 200),
            'dipublikasikan_pada' => now()->subDays(fake()->numberBetween(1, 150)),
        ];
    }
}
