<?php

namespace Database\Seeders;

use App\Models\Izin;
use Illuminate\Database\Seeder;

class IzinSeeder extends Seeder
{
    public function run(): void
    {
        $izin = [
            'kelola-pengguna' => 'pengguna',
            'verifikasi-guru' => 'pengguna',
            'kelola-master-data' => 'master',
            'kelola-e-modul' => 'konten',
            'tinjau-e-modul' => 'konten',
            'kelola-lkpd' => 'konten',
            'kelola-bahan-ajar' => 'konten',
            'kelola-video' => 'konten',
            'kelola-poster' => 'konten',
            'kelola-observasi' => 'konten',
            'kelola-kelas-belajar' => 'pembelajaran',
            'kelola-tugas' => 'pembelajaran',
            'kelola-website' => 'website',
            'kelola-pengaturan' => 'pengaturan',
            'lihat-laporan' => 'laporan',
        ];

        foreach ($izin as $nama => $kelompok) {
            Izin::query()->updateOrCreate(
                ['nama_izin' => $nama],
                ['kelompok' => $kelompok, 'keterangan' => ucwords(str_replace('-', ' ', $nama))]
            );
        }
    }
}
