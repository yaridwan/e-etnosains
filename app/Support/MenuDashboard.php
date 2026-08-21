<?php

namespace App\Support;

class MenuDashboard
{
    public static function administrator(): array
    {
        return [
            'Utama' => [
                self::item('Dashboard', route('admin.dashboard'), request()->routeIs('admin.dashboard')),
            ],
            'Verifikasi' => [
                self::item('Verifikasi Guru', route('admin.verifikasi-guru.index'), request()->routeIs('admin.verifikasi-guru.*')),
                self::item('Tinjau E-Modul', route('admin.tinjau-e-modul.index'), request()->routeIs('admin.tinjau-e-modul.*')),
            ],
            'Master Data' => [
                self::item('Jenjang Pendidikan', route('admin.jenjang-pendidikan.index'), request()->routeIs('admin.jenjang-pendidikan.*')),
                self::item('Mata Pelajaran', route('admin.mata-pelajaran.index'), request()->routeIs('admin.mata-pelajaran.*')),
                self::item('Topik Etnosains', route('admin.topik-etnosains.index'), request()->routeIs('admin.topik-etnosains.*')),
                self::item('Daerah Etnosains', route('admin.daerah-etnosains.index'), request()->routeIs('admin.daerah-etnosains.*')),
                self::item('Instansi Pendidikan', route('admin.instansi-pendidikan.index'), request()->routeIs('admin.instansi-pendidikan.*')),
                self::item('Tag', route('admin.tag.index'), request()->routeIs('admin.tag.*')),
            ],
            'Publikasi Website' => [
                self::item('Banner', route('admin.banner.index'), request()->routeIs('admin.banner.*')),
                self::item('Testimoni', route('admin.testimoni.index'), request()->routeIs('admin.testimoni.*')),
                self::item('FAQ', route('admin.faq.index'), request()->routeIs('admin.faq.*')),
                self::item('Halaman Statis', route('admin.halaman-statis.index'), request()->routeIs('admin.halaman-statis.*')),
                self::item('Pengumuman', route('admin.pengumuman.index'), request()->routeIs('admin.pengumuman.*')),
            ],
            'Pengguna' => [
                self::item('Semua Pengguna', route('admin.pengguna.index'), request()->routeIs('admin.pengguna.*')),
            ],
            'Sistem' => [
                self::item('Pengaturan Aplikasi', route('admin.pengaturan.index'), request()->routeIs('admin.pengaturan.*')),
                self::item('Audit Aktivitas', route('admin.audit-aktivitas.index'), request()->routeIs('admin.audit-aktivitas.*')),
            ],
        ];
    }

    public static function guru(): array
    {
        return [
            'Utama' => [
                self::item('Dashboard', route('guru.dashboard'), request()->routeIs('guru.dashboard')),
            ],
            'Konten' => [
                self::item('E-Modul Saya', route('guru.e-modul.index'), request()->routeIs('guru.e-modul.*')),
                self::item('LKPD Saya', route('guru.lkpd.index'), request()->routeIs('guru.lkpd.*')),
                self::item('Bahan Ajar Saya', route('guru.bahan-ajar.index'), request()->routeIs('guru.bahan-ajar.*')),
                self::item('Video Saya', route('guru.video.index'), request()->routeIs('guru.video.*')),
                self::item('Poster Saya', route('guru.poster.index'), request()->routeIs('guru.poster.*')),
                self::item('Observasi Saya', route('guru.observasi.index'), request()->routeIs('guru.observasi.*')),
            ],
            'Pembelajaran' => [
                self::item('Kelas Saya', route('guru.kelas.index'), request()->routeIs('guru.kelas.*')),
                self::item('Tugas & Penilaian', route('guru.tugas.index'), request()->routeIs('guru.tugas.*')),
                self::item('Pengumpulan Observasi', route('guru.pengumpulan-observasi.index'), request()->routeIs('guru.pengumpulan-observasi.*')),
            ],
            'Akun' => [
                self::item('Profil Saya', route('guru.profil.edit'), request()->routeIs('guru.profil.*')),
            ],
        ];
    }

    public static function siswa(): array
    {
        return [
            'Utama' => [
                self::item('Dashboard', route('siswa.dashboard'), request()->routeIs('siswa.dashboard')),
            ],
            'Belajar' => [
                self::item('Jelajahi E-Modul', route('e-modul.index'), false),
                self::item('Kelas Saya', route('siswa.kelas.index'), request()->routeIs('siswa.kelas.*')),
                self::item('Observasi Saya', route('siswa.observasi.index'), request()->routeIs('siswa.observasi.*')),
                self::item('Tugas Saya', route('siswa.tugas.index'), request()->routeIs('siswa.tugas.*')),
            ],
            'Lainnya' => [
                self::item('Favorit', route('siswa.favorit.index'), request()->routeIs('siswa.favorit.*')),
                self::item('Riwayat Belajar', route('siswa.riwayat.index'), request()->routeIs('siswa.riwayat.*')),
                self::item('Profil Saya', route('siswa.profil.edit'), request()->routeIs('siswa.profil.*')),
            ],
        ];
    }

    private static function item(string $label, string $url, bool $aktif): array
    {
        return ['label' => $label, 'url' => $url, 'aktif' => $aktif];
    }
}
