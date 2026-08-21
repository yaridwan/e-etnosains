<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faq = [
            ['Apa itu E-ETNOSAINS?', 'E-ETNOSAINS adalah platform e-modul pembelajaran yang menghubungkan konsep sains dengan kearifan lokal dan etnosains Indonesia.'],
            ['Apakah saya harus login untuk membaca e-modul?', 'Tidak. Pengunjung dapat membaca e-modul, LKPD, bahan ajar, dan video yang telah dipublikasikan tanpa perlu login.'],
            ['Bagaimana cara mendaftar sebagai guru?', 'Klik tombol "Daftar" pada halaman utama, pilih "Daftar sebagai Guru", lalu lengkapi data dan tunggu verifikasi dari Administrator.'],
            ['Berapa lama proses verifikasi akun guru?', 'Proses verifikasi biasanya memakan waktu 1-3 hari kerja setelah data guru lengkap dan diverifikasi email.'],
            ['Bagaimana cara siswa bergabung ke kelas belajar?', 'Siswa dapat bergabung menggunakan kode kelas yang diberikan oleh guru pengampu kelas.'],
            ['Apakah E-Modul dapat diunduh?', 'Bergantung pada pengaturan izin unduh yang ditetapkan oleh penulis E-Modul.'],
        ];

        foreach ($faq as $urutan => [$pertanyaan, $jawaban]) {
            Faq::query()->updateOrCreate(
                ['pertanyaan' => $pertanyaan],
                ['jawaban' => $jawaban, 'urutan' => $urutan, 'aktif' => true]
            );
        }
    }
}
