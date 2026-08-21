<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MataPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'IPA', 'Biologi', 'Fisika', 'Kimia', 'IPS',
            'Prakarya', 'Bahasa Indonesia', 'Pendidikan Lingkungan Hidup',
        ] as $nama) {
            MataPelajaran::query()->updateOrCreate(
                ['alamat_tautan' => Str::slug($nama)],
                ['nama_mata_pelajaran' => $nama]
            );
        }
    }
}
