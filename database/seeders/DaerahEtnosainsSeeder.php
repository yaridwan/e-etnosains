<?php

namespace Database\Seeders;

use App\Models\DaerahEtnosains;
use Illuminate\Database\Seeder;

class DaerahEtnosainsSeeder extends Seeder
{
    public function run(): void
    {
        $daerah = [
            ['provinsi' => 'Jawa Tengah', 'kabupaten_kota' => 'Banyumas', 'nama_kearifan_lokal' => 'Pengolahan Gula Aren'],
            ['provinsi' => 'D.I. Yogyakarta', 'kabupaten_kota' => 'Bantul', 'nama_kearifan_lokal' => 'Jamu Tradisional'],
            ['provinsi' => 'Jawa Barat', 'kabupaten_kota' => 'Subang', 'nama_kearifan_lokal' => 'Sistem Sawah Terasering'],
            ['provinsi' => 'Sumatera Barat', 'kabupaten_kota' => 'Agam', 'nama_kearifan_lokal' => 'Rendang dan Pengawetan Pangan'],
            ['provinsi' => 'Bali', 'kabupaten_kota' => 'Tabanan', 'nama_kearifan_lokal' => 'Subak (Sistem Irigasi Tradisional)'],
            ['provinsi' => 'Nusa Tenggara Timur', 'kabupaten_kota' => 'Sikka', 'nama_kearifan_lokal' => 'Konservasi Air Mata Air Adat'],
        ];

        foreach ($daerah as $data) {
            DaerahEtnosains::query()->updateOrCreate(
                ['provinsi' => $data['provinsi'], 'kabupaten_kota' => $data['kabupaten_kota']],
                $data
            );
        }
    }
}
