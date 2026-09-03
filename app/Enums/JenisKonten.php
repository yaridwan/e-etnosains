<?php

namespace App\Enums;

use App\Models\BahanAjar;
use App\Models\EModul;
use App\Models\Evaluasi;
use App\Models\Lkpd;
use App\Models\Observasi;
use App\Models\Poster;
use App\Models\VideoPembelajaran;

enum JenisKonten: string
{
    case EModul = 'e_modul';
    case Lkpd = 'lkpd';
    case BahanAjar = 'bahan_ajar';
    case VideoPembelajaran = 'video_pembelajaran';
    case Poster = 'poster';
    case Observasi = 'observasi';
    case Evaluasi = 'evaluasi';

    public function label(): string
    {
        return match ($this) {
            self::EModul => 'E-Modul',
            self::Lkpd => 'LKPD',
            self::BahanAjar => 'Bahan Ajar',
            self::VideoPembelajaran => 'Video Pembelajaran',
            self::Poster => 'Poster',
            self::Observasi => 'Observasi',
            self::Evaluasi => 'Evaluasi',
        };
    }

    public function modelClass(): string
    {
        return match ($this) {
            self::EModul => EModul::class,
            self::Lkpd => Lkpd::class,
            self::BahanAjar => BahanAjar::class,
            self::VideoPembelajaran => VideoPembelajaran::class,
            self::Poster => Poster::class,
            self::Observasi => Observasi::class,
            self::Evaluasi => Evaluasi::class,
        };
    }
}
