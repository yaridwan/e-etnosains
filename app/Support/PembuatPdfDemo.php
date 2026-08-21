<?php

namespace App\Support;

use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PembuatPdfDemo
{
    /**
     * Membuat berkas PDF demo multi-halaman dari judul dan daftar bagian,
     * lalu menyimpannya ke storage publik. Mengembalikan [path, jumlah_halaman].
     */
    public static function buat(string $judul, array $bagian, string $direktori): array
    {
        $opsi = new Options;
        $opsi->set('isRemoteEnabled', false);
        $opsi->set('defaultFont', 'DejaVu Sans');

        $html = '<style>
            body { font-family: "DejaVu Sans", sans-serif; color: #1e293b; }
            h1 { font-size: 20px; color: #0f766e; }
            h2 { font-size: 16px; color: #0f766e; margin-top: 0; }
            .halaman { page-break-after: always; padding: 20px; }
            .halaman:last-child { page-break-after: auto; }
            p { line-height: 1.6; font-size: 12px; }
        </style>';

        foreach ($bagian as $judulBagian => $isi) {
            $html .= '<div class="halaman">';
            $html .= '<h1>'.e($judul).'</h1>';
            $html .= '<h2>'.e($judulBagian).'</h2>';
            $html .= '<p>'.nl2br(e($isi)).'</p>';
            $html .= '</div>';
        }

        $dompdf = new Dompdf($opsi);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $namaBerkas = Str::uuid().'.pdf';
        $path = trim($direktori, '/').'/'.$namaBerkas;
        Storage::disk('public')->put($path, $dompdf->output());

        return [$path, count($bagian)];
    }
}
