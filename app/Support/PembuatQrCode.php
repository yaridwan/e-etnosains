<?php

namespace App\Support;

use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class PembuatQrCode
{
    /**
     * Menghasilkan QR Code sebagai data URI SVG sehingga dapat langsung
     * disematkan pada atribut src gambar tanpa menyimpan berkas.
     */
    public static function dataUri(string $isi, int $ukuran = 180): string
    {
        $renderer = new ImageRenderer(new RendererStyle($ukuran, 1), new SvgImageBackEnd);
        $svg = (new Writer($renderer))->writeString($isi);

        return 'data:image/svg+xml;base64,'.base64_encode($svg);
    }
}
