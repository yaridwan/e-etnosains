<?php

namespace Database\Seeders;

use App\Models\KategoriKonten;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KategoriKontenSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'E-Modul', 'LKPD', 'Bahan Ajar', 'Video Pembelajaran', 'Poster', 'Observasi',
        ] as $nama) {
            KategoriKonten::query()->updateOrCreate(
                ['alamat_tautan' => Str::slug($nama)],
                ['nama_kategori' => $nama]
            );
        }
    }
}
