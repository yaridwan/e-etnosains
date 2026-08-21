<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banner = [
            [
                'judul' => 'Belajar Sains dari Kearifan Lokal',
                'subjudul' => 'Temukan e-modul, LKPD, dan aktivitas observasi berbasis budaya serta kearifan lokal Indonesia.',
                'teks_tombol' => 'Jelajahi E-Modul',
                'tautan_tombol' => '/e-modul',
                'urutan' => 1,
            ],
            [
                'judul' => 'Bagikan Karya Pembelajaran Anda',
                'subjudul' => 'Bergabunglah sebagai guru dan publikasikan e-modul berbasis etnosains karya Anda.',
                'teks_tombol' => 'Daftar sebagai Guru',
                'tautan_tombol' => '/daftar/guru',
                'urutan' => 2,
            ],
        ];

        foreach ($banner as $data) {
            Banner::query()->updateOrCreate(['judul' => $data['judul']], $data + ['aktif' => true]);
        }
    }
}
