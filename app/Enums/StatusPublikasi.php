<?php

namespace App\Enums;

enum StatusPublikasi: string
{
    case Draf = 'draf';
    case Diajukan = 'diajukan';
    case DalamPeninjauan = 'dalam_peninjauan';
    case PerluPerbaikan = 'perlu_perbaikan';
    case Disetujui = 'disetujui';
    case Dijadwalkan = 'dijadwalkan';
    case Dipublikasikan = 'dipublikasikan';
    case Ditolak = 'ditolak';
    case Diarsipkan = 'diarsipkan';

    public function label(): string
    {
        return match ($this) {
            self::Draf => 'Draf',
            self::Diajukan => 'Diajukan',
            self::DalamPeninjauan => 'Dalam Peninjauan',
            self::PerluPerbaikan => 'Perlu Perbaikan',
            self::Disetujui => 'Disetujui',
            self::Dijadwalkan => 'Dijadwalkan Terbit',
            self::Dipublikasikan => 'Dipublikasikan',
            self::Ditolak => 'Ditolak',
            self::Diarsipkan => 'Diarsipkan',
        };
    }

    public function warnaBadge(): string
    {
        return match ($this) {
            self::Draf => 'slate',
            self::Diajukan, self::DalamPeninjauan => 'amber',
            self::PerluPerbaikan => 'orange',
            self::Disetujui => 'sky',
            self::Dijadwalkan => 'violet',
            self::Dipublikasikan => 'emerald',
            self::Ditolak => 'rose',
            self::Diarsipkan => 'gray',
        };
    }
}
