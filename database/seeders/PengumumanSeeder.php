<?php

namespace Database\Seeders;

use App\Models\Pengumuman;
use Illuminate\Database\Seeder;

class PengumumanSeeder extends Seeder
{
    public function run(): void
    {
        Pengumuman::query()->updateOrCreate(
            ['judul' => 'Selamat Datang di E-ETNOSAINS'],
            [
                'isi' => 'Jelajahi koleksi e-modul, LKPD, dan aktivitas observasi berbasis etnosains yang terus bertambah setiap bulannya.',
                'target' => 'umum',
                'tanggal_mulai' => now()->subDays(3),
                'tanggal_selesai' => now()->addMonths(3),
                'aktif' => true,
            ]
        );

        Pengumuman::query()->updateOrCreate(
            ['judul' => 'Batas Pengumpulan Tugas Diperpanjang'],
            [
                'isi' => 'Batas waktu pengumpulan tugas kelas belajar aktif diperpanjang hingga akhir bulan ini.',
                'target' => 'siswa',
                'tanggal_mulai' => now()->subDay(),
                'tanggal_selesai' => now()->addWeeks(2),
                'aktif' => true,
            ]
        );
    }
}
