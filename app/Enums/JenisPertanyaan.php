<?php

namespace App\Enums;

enum JenisPertanyaan: string
{
    case TeksPendek = 'teks_pendek';
    case TeksPanjang = 'teks_panjang';
    case Angka = 'angka';
    case Tanggal = 'tanggal';
    case Waktu = 'waktu';
    case PilihanTunggal = 'pilihan_tunggal';
    case PilihanGanda = 'pilihan_ganda';
    case Skala = 'skala';
    case YaTidak = 'ya_tidak';
    case UnggahFoto = 'unggah_foto';
    case UnggahBerkas = 'unggah_berkas';

    public function label(): string
    {
        return match ($this) {
            self::TeksPendek => 'Teks Pendek',
            self::TeksPanjang => 'Teks Panjang',
            self::Angka => 'Angka',
            self::Tanggal => 'Tanggal',
            self::Waktu => 'Waktu',
            self::PilihanTunggal => 'Pilihan Tunggal',
            self::PilihanGanda => 'Pilihan Ganda',
            self::Skala => 'Skala',
            self::YaTidak => 'Ya/Tidak',
            self::UnggahFoto => 'Unggah Foto',
            self::UnggahBerkas => 'Unggah Berkas',
        };
    }

    public function butuhOpsi(): bool
    {
        return in_array($this, [self::PilihanTunggal, self::PilihanGanda]);
    }
}
