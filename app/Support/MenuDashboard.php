<?php

namespace App\Support;

class MenuDashboard
{
    public static function administrator(): array
    {
        return [
            'Utama' => [
                self::item('Dashboard', route('admin.dashboard'), request()->routeIs('admin.dashboard'), 'grid'),
            ],
            'Verifikasi' => [
                self::item('Verifikasi Guru', route('admin.verifikasi-guru.index'), request()->routeIs('admin.verifikasi-guru.*'), 'perisai'),
                self::item('Verifikasi Siswa', route('admin.verifikasi-siswa.index'), request()->routeIs('admin.verifikasi-siswa.*'), 'lingkaran-pengguna'),
                self::item('Tinjau E-Modul', route('admin.tinjau-e-modul.index'), request()->routeIs('admin.tinjau-e-modul.*'), 'cari'),
            ],
            'Master Data' => [
                self::item('Jenjang Pendidikan', route('admin.jenjang-pendidikan.index'), request()->routeIs('admin.jenjang-pendidikan.*'), 'topi'),
                self::item('Mata Pelajaran', route('admin.mata-pelajaran.index'), request()->routeIs('admin.mata-pelajaran.*'), 'buku'),
                self::item('Topik Etnosains', route('admin.topik-etnosains.index'), request()->routeIs('admin.topik-etnosains.*'), 'lampu'),
                self::item('Daerah Etnosains', route('admin.daerah-etnosains.index'), request()->routeIs('admin.daerah-etnosains.*'), 'lokasi'),
                self::item('Instansi Pendidikan', route('admin.instansi-pendidikan.index'), request()->routeIs('admin.instansi-pendidikan.*'), 'gedung'),
                self::item('Tag', route('admin.tag.index'), request()->routeIs('admin.tag.*'), 'label'),
            ],
            'Publikasi Website' => [
                self::item('Banner', route('admin.banner.index'), request()->routeIs('admin.banner.*'), 'gambar'),
                self::item('Testimoni', route('admin.testimoni.index'), request()->routeIs('admin.testimoni.*'), 'obrolan'),
                self::item('FAQ', route('admin.faq.index'), request()->routeIs('admin.faq.*'), 'tanya'),
                self::item('Halaman Statis', route('admin.halaman-statis.index'), request()->routeIs('admin.halaman-statis.*'), 'dokumen'),
                self::item('Pengumuman', route('admin.pengumuman.index'), request()->routeIs('admin.pengumuman.*'), 'corong'),
            ],
            'Pengguna' => [
                self::item('Semua Pengguna', route('admin.pengguna.index'), request()->routeIs('admin.pengguna.*'), 'pengguna'),
            ],
            'Moderasi' => [
                self::item('Ulasan', route('admin.moderasi-ulasan.index'), request()->routeIs('admin.moderasi-ulasan.*'), 'bintang'),
            ],
            'Sistem' => [
                self::item('Notifikasi', route('notifikasi.index'), request()->routeIs('notifikasi.*'), 'lonceng'),
                self::item('Pengaturan Aplikasi', route('admin.pengaturan.index'), request()->routeIs('admin.pengaturan.*'), 'gerigi'),
                self::item('Audit Aktivitas', route('admin.audit-aktivitas.index'), request()->routeIs('admin.audit-aktivitas.*'), 'clipboard-list'),
            ],
        ];
    }

    public static function guru(): array
    {
        return [
            'Utama' => [
                self::item('Dashboard', route('guru.dashboard'), request()->routeIs('guru.dashboard'), 'grid'),
            ],
            'Konten' => [
                self::item('E-Modul Saya', route('guru.e-modul.index'), request()->routeIs('guru.e-modul.*'), 'tumpukan'),
                self::item('LKPD Saya', route('guru.lkpd.index'), request()->routeIs('guru.lkpd.*'), 'clipboard-centang'),
                self::item('Bahan Ajar Saya', route('guru.bahan-ajar.index'), request()->routeIs('guru.bahan-ajar.*'), 'folder'),
                self::item('Video Saya', route('guru.video.index'), request()->routeIs('guru.video.*'), 'putar'),
                self::item('Poster Saya', route('guru.poster.index'), request()->routeIs('guru.poster.*'), 'gambar'),
                self::item('Observasi Saya', route('guru.observasi.index'), request()->routeIs('guru.observasi.*'), 'mata'),
                self::item('Evaluasi Saya', route('guru.evaluasi.index'), request()->routeIs('guru.evaluasi.*'), 'dokumen'),
            ],
            'Pembelajaran' => [
                self::item('Kelas Saya', route('guru.kelas.index'), request()->routeIs('guru.kelas.*'), 'kelompok'),
                self::item('Tugas & Penilaian', route('guru.tugas.index'), request()->routeIs('guru.tugas.*'), 'lencana-centang'),
                self::item('Pengumpulan Observasi', route('guru.pengumpulan-observasi.index'), request()->routeIs('guru.pengumpulan-observasi.*'), 'kotak-masuk'),
            ],
            'Akun' => [
                self::item('Notifikasi', route('notifikasi.index'), request()->routeIs('notifikasi.*'), 'lonceng'),
                self::item('Profil Saya', route('guru.profil.edit'), request()->routeIs('guru.profil.*'), 'lingkaran-pengguna'),
            ],
        ];
    }

    public static function siswa(): array
    {
        return [
            'Utama' => [
                self::item('Dashboard', route('siswa.dashboard'), request()->routeIs('siswa.dashboard'), 'grid'),
            ],
            'Belajar' => [
                self::item('Jelajahi E-Modul', route('e-modul.index'), false, 'cari'),
                self::item('Kelas Saya', route('siswa.kelas.index'), request()->routeIs('siswa.kelas.*'), 'kelompok'),
                self::item('Observasi Saya', route('siswa.observasi.index'), request()->routeIs('siswa.observasi.*'), 'mata'),
                self::item('Tugas Saya', route('siswa.tugas.index'), request()->routeIs('siswa.tugas.*'), 'lencana-centang'),
            ],
            'Lainnya' => [
                self::item('Favorit', route('siswa.favorit.index'), request()->routeIs('siswa.favorit.*'), 'hati'),
                self::item('Riwayat Belajar', route('siswa.riwayat.index'), request()->routeIs('siswa.riwayat.*'), 'jam'),
                self::item('Notifikasi', route('notifikasi.index'), request()->routeIs('notifikasi.*'), 'lonceng'),
                self::item('Profil Saya', route('siswa.profil.edit'), request()->routeIs('siswa.profil.*'), 'lingkaran-pengguna'),
            ],
        ];
    }

    private static function item(string $label, string $url, bool $aktif, string $ikon): array
    {
        return ['label' => $label, 'url' => $url, 'aktif' => $aktif, 'ikon' => $ikon];
    }
}
