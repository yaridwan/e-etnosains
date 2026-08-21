<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadService
{
    public function simpanGambar(UploadedFile $berkas, string $direktori): string
    {
        $namaBerkas = Str::uuid().'.'.$berkas->extension();

        return $berkas->storeAs($direktori, $namaBerkas, 'public');
    }

    public function simpanDokumen(UploadedFile $berkas, string $direktori): string
    {
        $namaBerkas = Str::uuid().'.'.$berkas->extension();

        return $berkas->storeAs($direktori, $namaBerkas, 'public');
    }

    public function hapus(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
