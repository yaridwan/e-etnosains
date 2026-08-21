<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Membuat berkas gambar demo (SVG) untuk mengisi kolom poster, sampul, dan
 * dokumentasi pada data seeder. SVG dipilih agar tidak memerlukan ekstensi
 * grafis apa pun dan tetap tajam pada ukuran berapa pun.
 */
class PembuatPosterDemo
{
    private const PALET = ['#0f766e', '#155e75', '#ca8a04', '#b45309', '#166534', '#7c2d12'];

    /**
     * Poster potret 3:4, dipakai untuk galeri poster dan dokumentasi observasi.
     */
    public static function buat(string $judul, string $direktori = 'poster'): string
    {
        return self::simpan(
            self::svg($judul, 600, 800, 'Poster Pembelajaran Etnosains'),
            $direktori
        );
    }

    /**
     * Sampul lanskap 4:3, dipakai untuk kartu E-Modul dan LKPD.
     */
    public static function sampul(string $judul, string $direktori = 'e-modul/sampul'): string
    {
        return self::simpan(
            self::svg($judul, 800, 600, 'E-Modul Berbasis Etnosains'),
            $direktori
        );
    }

    private static function svg(string $judul, int $lebar, int $tinggi, string $kaki): string
    {
        $warna = self::PALET[crc32($judul) % count(self::PALET)];
        $tengahX = intdiv($lebar, 2);
        $tengahY = intdiv($tinggi, 2);

        // Judul dipecah menjadi beberapa baris agar tidak terpotong pada gambar.
        $baris = self::pecahBaris($judul, 28);
        $ukuranJudul = $lebar >= 800 ? 30 : 26;
        $mulaiY = $tengahY - (count($baris) - 1) * ($ukuranJudul + 8) / 2;

        $teksJudul = '';
        foreach ($baris as $i => $isi) {
            $y = (int) round($mulaiY + $i * ($ukuranJudul + 8));
            $aman = htmlspecialchars($isi, ENT_XML1);
            $teksJudul .= "<text x=\"{$tengahX}\" y=\"{$y}\" font-family=\"sans-serif\" font-size=\"{$ukuranJudul}\" font-weight=\"bold\" fill=\"white\" text-anchor=\"middle\">{$aman}</text>";
        }

        $labelY = (int) round($mulaiY - $ukuranJudul - 28);
        $kakiY = $tinggi - 40;
        $bingkaiLebar = $lebar - 48;
        $bingkaiTinggi = $tinggi - 48;

        return <<<SVG
        <svg xmlns="http://www.w3.org/2000/svg" width="{$lebar}" height="{$tinggi}" viewBox="0 0 {$lebar} {$tinggi}">
            <rect width="{$lebar}" height="{$tinggi}" fill="{$warna}"/>
            <rect x="24" y="24" width="{$bingkaiLebar}" height="{$bingkaiTinggi}" fill="none" stroke="white" stroke-width="2" stroke-opacity="0.35"/>
            <text x="{$tengahX}" y="{$labelY}" font-family="sans-serif" font-size="16" fill="white" text-anchor="middle" opacity="0.75" letter-spacing="3">E-ETNOSAINS</text>
            {$teksJudul}
            <text x="{$tengahX}" y="{$kakiY}" font-family="sans-serif" font-size="14" fill="white" text-anchor="middle" opacity="0.7">{$kaki}</text>
        </svg>
        SVG;
    }

    /**
     * @return list<string>
     */
    private static function pecahBaris(string $judul, int $maksKarakter): array
    {
        $judul = Str::limit($judul, 90, '');
        $baris = [];
        $sekarang = '';

        foreach (explode(' ', $judul) as $kata) {
            $calon = $sekarang === '' ? $kata : $sekarang.' '.$kata;

            if (mb_strlen($calon) > $maksKarakter && $sekarang !== '') {
                $baris[] = $sekarang;
                $sekarang = $kata;

                continue;
            }

            $sekarang = $calon;
        }

        if ($sekarang !== '') {
            $baris[] = $sekarang;
        }

        return $baris ?: [$judul];
    }

    private static function simpan(string $svg, string $direktori): string
    {
        $path = trim($direktori, '/').'/'.Str::uuid().'.svg';
        Storage::disk('public')->put($path, $svg);

        return $path;
    }
}
