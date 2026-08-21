<?php

namespace Database\Seeders;

use App\Models\TopikEtnosains;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TopikEtnosainsSeeder extends Seeder
{
    public function run(): void
    {
        $topik = [
            'Pertanian Tradisional' => 'Praktik bercocok tanam turun-temurun dan sains di baliknya.',
            'Perkebunan' => 'Pengelolaan kebun rakyat dan tanaman perkebunan lokal.',
            'Tanaman Obat' => 'Pemanfaatan tanaman obat tradisional oleh masyarakat.',
            'Makanan Tradisional' => 'Proses pengolahan makanan khas daerah dan konsep sains terkait.',
            'Teknologi Tradisional' => 'Peralatan dan teknik tradisional dalam kehidupan sehari-hari.',
            'Lingkungan' => 'Kearifan lokal dalam menjaga kelestarian lingkungan.',
            'Ekosistem' => 'Interaksi makhluk hidup dalam ekosistem khas daerah.',
            'Sumber Daya Air' => 'Pengelolaan dan konservasi air berbasis kearifan lokal.',
            'Tanah' => 'Pengetahuan tradisional tentang kesuburan dan pengelolaan tanah.',
            'Energi' => 'Pemanfaatan sumber energi tradisional masyarakat.',
            'Kerajinan Tradisional' => 'Proses pembuatan kerajinan khas daerah dan sains di dalamnya.',
            'Kearifan Lokal' => 'Nilai dan praktik kearifan lokal secara umum.',
            'Arsitektur Tradisional' => 'Prinsip sains dalam bangunan dan rumah adat.',
            'Pengolahan Pangan' => 'Teknik pengawetan dan pengolahan pangan tradisional.',
            'Budaya dan Sains' => 'Hubungan umum antara praktik budaya dan konsep sains.',
        ];

        foreach ($topik as $nama => $deskripsi) {
            TopikEtnosains::query()->updateOrCreate(
                ['alamat_tautan' => Str::slug($nama)],
                ['nama_topik' => $nama, 'deskripsi' => $deskripsi]
            );
        }
    }
}
