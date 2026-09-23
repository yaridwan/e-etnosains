<?php

namespace Database\Seeders;

use App\Models\HalamanStatis;
use Illuminate\Database\Seeder;

class HalamanStatisSeeder extends Seeder
{
    public function run(): void
    {
        $halaman = [
            [
                'judul' => 'Tentang Kami',
                'alamat_tautan' => 'tentang',
                'konten' => '<p>E-ETNOSAINS adalah platform e-modul pembelajaran berbasis etnosains dan kearifan lokal yang menghubungkan konsep sains dengan budaya Indonesia untuk mendukung pembelajaran yang kontekstual dan bermakna.</p>',
            ],
            [
                'judul' => 'Panduan Penggunaan',
                'alamat_tautan' => 'panduan',
                'konten' => '<p>Pengunjung dapat menjelajahi e-modul secara bebas. Guru dapat mendaftar untuk menyusun dan mempublikasikan konten. Siswa dapat mendaftar untuk mengikuti kelas, mengerjakan LKPD, dan melakukan observasi.</p>',
            ],
            [
                'judul' => 'Kebijakan Privasi',
                'alamat_tautan' => 'kebijakan-privasi',
                'konten' => '<p>E-ETNOSAINS menghormati privasi pengguna. Data akun digunakan hanya untuk keperluan layanan pembelajaran dan tidak dibagikan kepada pihak ketiga tanpa persetujuan.</p>',
            ],
            [
                'judul' => 'Syarat Penggunaan',
                'alamat_tautan' => 'syarat-penggunaan',
                'konten' => '<p>Pengguna wajib menggunakan platform ini secara bertanggung jawab dan tidak mempublikasikan konten yang melanggar hukum atau hak cipta pihak lain.</p>',
            ],
            [
                'judul' => 'Kontak',
                'alamat_tautan' => 'kontak',
                'konten' => '<p>Hubungi tim E-ETNOSAINS melalui email hello@e-etnosains.com untuk pertanyaan, kritik, dan saran.</p>',
            ],
        ];

        foreach ($halaman as $data) {
            HalamanStatis::query()->updateOrCreate(['alamat_tautan' => $data['alamat_tautan']], $data);
        }
    }
}
