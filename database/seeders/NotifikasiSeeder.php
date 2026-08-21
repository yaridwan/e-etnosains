<?php

namespace Database\Seeders;

use App\Models\Notifikasi;
use App\Models\Peran;
use Illuminate\Database\Seeder;

class NotifikasiSeeder extends Seeder
{
    public function run(): void
    {
        $guru = Peran::where('nama_peran', 'guru')->firstOrFail()->pengguna;
        $siswa = Peran::where('nama_peran', 'siswa')->firstOrFail()->pengguna;

        foreach ($guru->take(3) as $pengajar) {
            Notifikasi::create([
                'id_pengguna' => $pengajar->id,
                'tipe' => 'verifikasi_guru',
                'judul' => 'Akun Anda Telah Disetujui',
                'pesan' => 'Selamat! Akun guru Anda telah diverifikasi Administrator dan kini dapat digunakan untuk mempublikasikan konten.',
                'dibaca_pada' => now()->subDays(5),
            ]);

            $eModul = $pengajar->eModul()->first();

            if ($eModul) {
                Notifikasi::create([
                    'id_pengguna' => $pengajar->id,
                    'tipe' => 'e_modul',
                    'judul' => 'E-Modul Anda Dipublikasikan',
                    'pesan' => 'E-Modul "'.$eModul->judul.'" telah disetujui dan kini tampil di portal publik.',
                    'data' => ['id_e_modul' => $eModul->id],
                ]);
            }
        }

        foreach ($siswa->take(5) as $murid) {
            Notifikasi::create([
                'id_pengguna' => $murid->id,
                'tipe' => 'tugas',
                'judul' => 'Tugas Baru di Kelas Anda',
                'pesan' => 'Guru menambahkan tugas "Laporan Observasi Etnosains". Periksa batas waktu pengumpulannya.',
            ]);
        }
    }
}
