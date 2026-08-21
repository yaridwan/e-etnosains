<?php

namespace App\Services;

use App\Models\RiwayatBaca;
use App\Models\RiwayatUnduhan;
use App\Models\StatistikKunjungan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AktivitasKontenService
{
    public function catatDilihat(Model $konten, string $jenisKonten, Request $request): void
    {
        $konten->increment('jumlah_dilihat');

        RiwayatBaca::create([
            'id_pengguna' => $request->user()?->id,
            'jenis_konten' => $jenisKonten,
            'id_referensi' => $konten->id,
            'alamat_ip' => $request->ip(),
        ]);

        StatistikKunjungan::create([
            'url' => $request->path(),
            'jenis_konten' => $jenisKonten,
            'id_referensi' => $konten->id,
            'alamat_ip' => $request->ip(),
            'agen_pengguna' => $request->userAgent(),
        ]);
    }

    public function catatUnduhan(Model $konten, string $jenisKonten, Request $request): void
    {
        $konten->increment('jumlah_diunduh');

        RiwayatUnduhan::create([
            'id_pengguna' => $request->user()?->id,
            'jenis_konten' => $jenisKonten,
            'id_referensi' => $konten->id,
            'alamat_ip' => $request->ip(),
        ]);
    }
}
