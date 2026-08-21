<?php

namespace App\Services;

use App\Models\PengaturanAplikasi;
use Illuminate\Support\Facades\Cache;

class PengaturanService
{
    public function semua(): array
    {
        return Cache::rememberForever('pengaturan_aplikasi', function () {
            return PengaturanAplikasi::query()->pluck('nilai', 'kunci')->all();
        });
    }

    public function ambil(string $kunci, mixed $default = null): mixed
    {
        return $this->semua()[$kunci] ?? $default;
    }

    public function ambilBoolean(string $kunci, bool $default = false): bool
    {
        $nilai = $this->ambil($kunci);

        return $nilai === null ? $default : (bool) $nilai;
    }

    public function simpan(string $kunci, mixed $nilai): void
    {
        PengaturanAplikasi::query()->where('kunci', $kunci)->update(['nilai' => $nilai]);

        Cache::forget('pengaturan_aplikasi');
    }

    public function kelompok(string $kelompok): array
    {
        return PengaturanAplikasi::query()
            ->where('kelompok', $kelompok)
            ->get()
            ->keyBy('kunci')
            ->all();
    }
}
