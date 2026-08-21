<?php

namespace App\Enums;

enum StatusAkun: string
{
    case Aktif = 'aktif';
    case MenungguVerifikasi = 'menunggu_verifikasi';
    case Ditolak = 'ditolak';
    case Nonaktif = 'nonaktif';

    public function label(): string
    {
        return match ($this) {
            self::Aktif => 'Aktif',
            self::MenungguVerifikasi => 'Menunggu Verifikasi',
            self::Ditolak => 'Ditolak',
            self::Nonaktif => 'Nonaktif',
        };
    }
}
