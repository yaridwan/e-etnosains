<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PembuatPosterDemo
{
    /**
     * Membuat berkas gambar poster demo (SVG) sederhana lalu menyimpannya
     * ke storage publik. Mengembalikan path relatifnya.
     */
    public static function buat(string $judul, string $direktori = 'poster'): string
    {
        $warna = ['#0f766e', '#155e75', '#ca8a04', '#b45309', '#166534'][crc32($judul) % 5];
        $judulEscaped = htmlspecialchars(Str::limit($judul, 60), ENT_XML1);

        $svg = <<<SVG
        <svg xmlns="http://www.w3.org/2000/svg" width="600" height="800" viewBox="0 0 600 800">
            <rect width="600" height="800" fill="{$warna}"/>
            <rect x="24" y="24" width="552" height="752" fill="none" stroke="white" stroke-width="2" stroke-opacity="0.4"/>
            <text x="300" y="370" font-family="sans-serif" font-size="28" font-weight="bold" fill="white" text-anchor="middle">E-ETNOSAINS</text>
            <text x="300" y="420" font-family="sans-serif" font-size="18" fill="white" text-anchor="middle" opacity="0.9">{$judulEscaped}</text>
            <text x="300" y="760" font-family="sans-serif" font-size="14" fill="white" text-anchor="middle" opacity="0.7">Poster Pembelajaran Etnosains</text>
        </svg>
        SVG;

        $namaBerkas = Str::uuid().'.svg';
        $path = trim($direktori, '/').'/'.$namaBerkas;
        Storage::disk('public')->put($path, $svg);

        return $path;
    }
}
