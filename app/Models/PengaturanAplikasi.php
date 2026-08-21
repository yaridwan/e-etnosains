<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;

class PengaturanAplikasi extends ModelDasar
{
    protected $table = 'pengaturan_aplikasi';

    protected $fillable = ['kelompok', 'kunci', 'nilai', 'tipe', 'keterangan', 'dapat_diubah'];

    protected function casts(): array
    {
        return [
            'dapat_diubah' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('pengaturan_aplikasi'));
        static::deleted(fn () => Cache::forget('pengaturan_aplikasi'));
    }
}
