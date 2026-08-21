<?php

namespace App\Support;

/**
 * Kumpulan judul dan teks berbahasa Indonesia bertema etnosains untuk mengisi
 * data demo. Dipakai factory agar data hasil seeder terasa nyata, bukan
 * lorem ipsum.
 */
class JudulDemo
{
    /** @var list<string> */
    private const E_MODUL = [
        'Fermentasi Tradisional Tempe dan Konsep Bioteknologi',
        'Sains di Balik Kerajinan Anyaman Bambu',
        'Pewarna Alami Batik dan Reaksi Kimia Zat Warna',
        'Teknologi Lumbung Padi dan Prinsip Pengawetan Biji',
        'Perahu Tradisional dan Konsep Gaya Apung',
        'Pengolahan Sagu serta Konsep Karbohidrat dan Enzim',
        'Rumah Panggung dan Prinsip Kesetimbangan Struktur',
        'Garam Rakyat dan Proses Kristalisasi Air Laut',
        'Pandai Besi Tradisional dan Konsep Perpindahan Kalor',
        'Terasering Sawah dan Pengendalian Erosi Tanah',
        'Gerabah Tanah Liat dan Perubahan Sifat Materi',
        'Pengasapan Ikan dan Prinsip Pengawetan Pangan',
    ];

    /** @var list<string> */
    private const AKTIVITAS_OBSERVASI = [
        'Pemanfaatan Tanaman Pekarangan sebagai Bumbu Dapur',
        'Pengelolaan Sampah Organik di Lingkungan Sekitar',
        'Jenis Burung dan Perannya pada Ekosistem Kebun',
        'Sumber Air Bersih dan Cara Masyarakat Menjaganya',
        'Alat Dapur Tradisional dan Fungsi Ilmiahnya',
        'Tanaman Pelindung Jalan dan Manfaat Ekologisnya',
    ];

    /** @var list<string> */
    private const BAHAN_AJAR = [
        'Ringkasan Materi Perubahan Wujud Zat',
        'Peta Konsep Ekosistem Lokal',
        'Panduan Praktikum Sederhana Uji Amilum',
        'Glosarium Istilah Etnosains Nusantara',
        'Lembar Pengayaan Keanekaragaman Hayati',
        'Rangkuman Siklus Air dan Kearifan Lokal',
        'Kumpulan Soal Latihan Perpindahan Kalor',
        'Infografis Tanaman Obat Keluarga',
    ];

    /** @var list<string> */
    private const POSTER = [
        'Jaga Mata Air, Jaga Kehidupan',
        'Ragam Tanaman Obat Nusantara',
        'Langkah Pengolahan Sampah Organik',
        'Rantai Makanan di Ekosistem Sawah',
        'Kearifan Lokal Hemat Energi',
        'Proses Pembuatan Gula Aren',
        'Mengenal Sistem Irigasi Subak',
        'Pengawetan Pangan Cara Tradisional',
    ];

    /** @var list<string> */
    private const KETERANGAN = [
        'Materi ini menghubungkan praktik kearifan lokal masyarakat dengan konsep sains yang dipelajari di sekolah.',
        'Disusun agar peserta didik dapat mengamati fenomena budaya di sekitarnya dan menjelaskannya secara ilmiah.',
        'Menekankan kegiatan pengamatan langsung sehingga pembelajaran terasa dekat dengan keseharian siswa.',
        'Memuat contoh nyata dari lingkungan sekitar beserta penjelasan konsep sains yang mendasarinya.',
        'Dirancang untuk menumbuhkan apresiasi terhadap warisan budaya sekaligus penguasaan konsep sains.',
    ];

    public static function eModul(): string
    {
        return self::acak(self::E_MODUL);
    }

    public static function observasi(): string
    {
        return 'Observasi '.self::acak(self::AKTIVITAS_OBSERVASI);
    }

    public static function lkpd(): string
    {
        return 'LKPD '.self::acak(self::AKTIVITAS_OBSERVASI);
    }

    public static function bahanAjar(): string
    {
        return self::acak(self::BAHAN_AJAR);
    }

    public static function poster(): string
    {
        return self::acak(self::POSTER);
    }

    public static function video(): string
    {
        return 'Video Pembelajaran: '.self::acak(self::E_MODUL);
    }

    public static function keterangan(): string
    {
        return self::acak(self::KETERANGAN);
    }

    /**
     * Mengambil satu judul acak lalu menambahkan pembeda bila judul dasar sudah
     * terpakai, sehingga kolom unik seperti alamat_tautan tidak bentrok.
     *
     * @param  list<string>  $daftar
     */
    private static function acak(array $daftar): string
    {
        static $terpakai = [];

        $judul = $daftar[array_rand($daftar)];
        $kunci = $judul;

        if (! isset($terpakai[$kunci])) {
            $terpakai[$kunci] = 1;

            return $judul;
        }

        $terpakai[$kunci]++;

        return $judul.' ('.$terpakai[$kunci].')';
    }
}
