<?php

namespace App\Services;

use App\Enums\StatusPublikasi;
use App\Models\EModul;
use App\Models\Pengguna;
use App\Models\RiwayatStatusEModul;
use Illuminate\Support\Facades\DB;

class PublikasiEModulService
{
    public function simpanDraf(Pengguna $guru, array $data): EModul
    {
        return DB::transaction(function () use ($guru, $data) {
            $data['izin_unduh'] = $data['izin_unduh'] ?? false;

            return $guru->eModul()->create($data + ['status_publikasi' => StatusPublikasi::Draf]);
        });
    }

    public function perbarui(EModul $eModul, array $data): EModul
    {
        $data['izin_unduh'] = $data['izin_unduh'] ?? false;
        $eModul->update($data);

        return $eModul;
    }

    public function ajukan(EModul $eModul, Pengguna $pengajuan): EModul
    {
        return DB::transaction(function () use ($eModul, $pengajuan) {
            $statusSebelum = $eModul->status_publikasi->value;

            $eModul->update(['status_publikasi' => StatusPublikasi::Diajukan]);

            RiwayatStatusEModul::create([
                'id_e_modul' => $eModul->id,
                'status_sebelum' => $statusSebelum,
                'status_sesudah' => StatusPublikasi::Diajukan->value,
                'catatan' => 'Diajukan oleh guru untuk ditinjau.',
                'id_pengguna' => $pengajuan->id,
            ]);

            return $eModul;
        });
    }
}
