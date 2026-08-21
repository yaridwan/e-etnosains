<?php

namespace App\Enums;

enum JenisKonten: string
{
    case EModul = 'e_modul';
    case Lkpd = 'lkpd';
    case BahanAjar = 'bahan_ajar';
    case VideoPembelajaran = 'video_pembelajaran';
    case Poster = 'poster';
    case Observasi = 'observasi';

    public function label(): string
    {
        return match ($this) {
            self::EModul => 'E-Modul',
            self::Lkpd => 'LKPD',
            self::BahanAjar => 'Bahan Ajar',
            self::VideoPembelajaran => 'Video Pembelajaran',
            self::Poster => 'Poster',
            self::Observasi => 'Observasi',
        };
    }

    public function modelClass(): string
    {
        return match ($this) {
            self::EModul => \App\Models\EModul::class,
            self::Lkpd => \App\Models\Lkpd::class,
            self::BahanAjar => \App\Models\BahanAjar::class,
            self::VideoPembelajaran => \App\Models\VideoPembelajaran::class,
            self::Poster => \App\Models\Poster::class,
            self::Observasi => \App\Models\Observasi::class,
        };
    }
}
