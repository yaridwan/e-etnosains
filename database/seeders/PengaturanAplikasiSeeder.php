<?php

namespace Database\Seeders;

use App\Models\PengaturanAplikasi;
use Illuminate\Database\Seeder;

class PengaturanAplikasiSeeder extends Seeder
{
    public function run(): void
    {
        $pengaturan = [
            // Identitas
            ['identitas', 'nama_aplikasi', 'E-ETNOSAINS', 'teks', 'Nama aplikasi'],
            ['identitas', 'nama_singkat', 'E-ETNOSAINS', 'teks', 'Nama singkat aplikasi'],
            ['identitas', 'slogan', 'Platform E-Modul Pembelajaran Berbasis Etnosains dan Kearifan Lokal', 'teks', 'Slogan aplikasi'],
            ['identitas', 'deskripsi', 'E-ETNOSAINS menghubungkan konsep sains dengan kearifan lokal Indonesia melalui e-modul, LKPD, observasi, dan video pembelajaran.', 'teks_panjang', 'Deskripsi aplikasi'],
            ['identitas', 'logo_utama', '', 'berkas', 'Logo utama aplikasi'],
            ['identitas', 'favicon', '', 'berkas', 'Favicon aplikasi'],
            ['identitas', 'nama_institusi', 'E-ETNOSAINS', 'teks', 'Nama institusi pengelola'],

            // Tampilan
            ['tampilan', 'warna_utama', '#0f766e', 'warna', 'Warna utama tema'],
            ['tampilan', 'warna_sekunder', '#155e75', 'warna', 'Warna sekunder tema'],
            ['tampilan', 'warna_aksen', '#ca8a04', 'warna', 'Warna aksen tema'],

            // Kontak
            ['kontak', 'email', 'hello@e-etnosains.test', 'teks', 'Email kontak'],
            ['kontak', 'nomor_telepon', '+62 811-0000-0000', 'teks', 'Nomor telepon kontak'],
            ['kontak', 'whatsapp', '+62 811-0000-0000', 'teks', 'Nomor WhatsApp kontak'],
            ['kontak', 'alamat', 'Yogyakarta, Indonesia', 'teks', 'Alamat institusi'],

            // Media sosial
            ['media_sosial', 'facebook', '', 'teks', 'Tautan Facebook'],
            ['media_sosial', 'instagram', '', 'teks', 'Tautan Instagram'],
            ['media_sosial', 'youtube', '', 'teks', 'Tautan YouTube'],
            ['media_sosial', 'tiktok', '', 'teks', 'Tautan TikTok'],

            // SEO
            ['seo', 'judul_seo', 'E-ETNOSAINS | Platform E-Modul Pembelajaran Berbasis Etnosains', 'teks', 'Judul SEO default'],
            ['seo', 'deskripsi_seo', 'Jelajahi e-modul, LKPD, bahan ajar, observasi, dan video pembelajaran berbasis etnosains dan kearifan lokal Indonesia.', 'teks_panjang', 'Deskripsi SEO default'],
            ['seo', 'kata_kunci', 'etnosains, kearifan lokal, e-modul, pembelajaran sains, LKPD', 'teks', 'Kata kunci SEO'],
            ['seo', 'google_analytics_id', '', 'teks', 'Google Analytics ID'],

            // Registrasi
            ['registrasi', 'registrasi_guru', '1', 'boolean', 'Aktifkan registrasi guru'],
            ['registrasi', 'registrasi_siswa', '1', 'boolean', 'Aktifkan registrasi siswa'],
            ['registrasi', 'registrasi_siswa_perlu_persetujuan', '1', 'boolean', 'Registrasi siswa memerlukan persetujuan admin'],

            // Pembelajaran
            ['pembelajaran', 'publikasi_otomatis_guru_terverifikasi', '0', 'boolean', 'Publikasi otomatis untuk guru terverifikasi'],
            ['pembelajaran', 'ulasan_aktif', '1', 'boolean', 'Aktifkan fitur ulasan'],
            ['pembelajaran', 'unduhan_e_modul_aktif', '1', 'boolean', 'Aktifkan unduhan e-modul'],
            ['pembelajaran', 'kelas_belajar_aktif', '1', 'boolean', 'Aktifkan fitur kelas belajar'],
            ['pembelajaran', 'observasi_aktif', '1', 'boolean', 'Aktifkan fitur observasi'],

            // Upload
            ['upload', 'batas_ukuran_e_modul_mb', '50', 'angka', 'Batas ukuran unggah E-Modul (MB)'],
            ['upload', 'batas_ukuran_dokumen_mb', '20', 'angka', 'Batas ukuran unggah dokumen (MB)'],
            ['upload', 'batas_ukuran_gambar_mb', '5', 'angka', 'Batas ukuran unggah gambar (MB)'],
        ];

        foreach ($pengaturan as [$kelompok, $kunci, $nilai, $tipe, $keterangan]) {
            PengaturanAplikasi::query()->updateOrCreate(
                ['kunci' => $kunci],
                ['kelompok' => $kelompok, 'nilai' => $nilai, 'tipe' => $tipe, 'keterangan' => $keterangan]
            );
        }
    }
}
