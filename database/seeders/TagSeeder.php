<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'etnosains', 'kearifan-lokal', 'lingkungan', 'budaya', 'sains-sederhana',
            'observasi-lapangan', 'gotong-royong', 'konservasi',
        ] as $nama) {
            Tag::query()->updateOrCreate(
                ['alamat_tautan' => Str::slug($nama)],
                ['nama_tag' => ucwords(str_replace('-', ' ', $nama))]
            );
        }
    }
}
