<?php

use App\Services\PengaturanService;

if (! function_exists('pengaturan')) {
    function pengaturan(string $kunci, mixed $default = null): mixed
    {
        return app(PengaturanService::class)->ambil($kunci, $default);
    }
}

if (! function_exists('pengaturan_aktif')) {
    function pengaturan_aktif(string $kunci, bool $default = false): bool
    {
        return app(PengaturanService::class)->ambilBoolean($kunci, $default);
    }
}
