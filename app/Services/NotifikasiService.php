<?php

namespace App\Services;

use App\Models\Notifikasi;
use App\Models\Pengguna;

class NotifikasiService
{
    public function kirim(Pengguna|int $pengguna, string $tipe, string $judul, string $pesan, array $data = []): Notifikasi
    {
        return Notifikasi::create([
            'id_pengguna' => $pengguna instanceof Pengguna ? $pengguna->id : $pengguna,
            'tipe' => $tipe,
            'judul' => $judul,
            'pesan' => $pesan,
            'data' => $data ?: null,
        ]);
    }

    public function tandaiDibaca(Notifikasi $notifikasi): void
    {
        if (! $notifikasi->sudahDibaca()) {
            $notifikasi->update(['dibaca_pada' => now()]);
        }
    }

    public function tandaiSemuaDibaca(Pengguna $pengguna): void
    {
        $pengguna->notifikasi()->whereNull('dibaca_pada')->update(['dibaca_pada' => now()]);
    }

    public function jumlahBelumDibaca(Pengguna $pengguna): int
    {
        return $pengguna->notifikasi()->whereNull('dibaca_pada')->count();
    }
}
