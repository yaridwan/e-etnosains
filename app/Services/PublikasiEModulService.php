<?php

namespace App\Services;

use App\Enums\StatusPublikasi;
use App\Models\EModul;
use App\Models\Pengguna;
use App\Models\RiwayatStatusEModul;
use App\Models\VersiEModul;
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

    /**
     * Menandai E-Modul agar terbit otomatis pada waktu tertentu di masa
     * depan. Status tetap "dijadwalkan" (belum tampil di portal publik)
     * sampai perintah terjadwal benar-benar menerbitkannya.
     */
    public function jadwalkan(EModul $eModul, Pengguna $admin, \DateTimeInterface $waktuTerbit, ?string $catatan = null): EModul
    {
        return DB::transaction(function () use ($eModul, $admin, $waktuTerbit, $catatan) {
            $statusSebelum = $eModul->status_publikasi->value;

            $eModul->update([
                'status_publikasi' => StatusPublikasi::Dijadwalkan,
                'dijadwalkan_pada' => $waktuTerbit,
                'catatan_reviewer' => $catatan,
            ]);

            RiwayatStatusEModul::create([
                'id_e_modul' => $eModul->id,
                'status_sebelum' => $statusSebelum,
                'status_sesudah' => StatusPublikasi::Dijadwalkan->value,
                'catatan' => $catatan ?: 'Disetujui, dijadwalkan terbit pada '.$waktuTerbit->format('d-m-Y H:i').'.',
                'id_pengguna' => $admin->id,
            ]);

            return $eModul;
        });
    }

    /**
     * Menerbitkan E-Modul sekarang juga: mengubah status menjadi
     * "dipublikasikan" dan membekukan isinya sebagai versi baru yang tidak
     * akan pernah ditimpa. Dipakai baik untuk persetujuan langsung oleh
     * Administrator maupun oleh perintah terjadwal (lihat TerbitkanEModulTerjadwal).
     */
    public function terbitkan(EModul $eModul, ?Pengguna $penerbit = null, ?string $catatan = null): EModul
    {
        return DB::transaction(function () use ($eModul, $penerbit, $catatan) {
            $statusSebelum = $eModul->status_publikasi->value;

            $eModul->update([
                'status_publikasi' => StatusPublikasi::Dipublikasikan,
                'dipublikasikan_pada' => now(),
                'dijadwalkan_pada' => null,
                'catatan_reviewer' => $catatan ?? $eModul->catatan_reviewer,
            ]);

            RiwayatStatusEModul::create([
                'id_e_modul' => $eModul->id,
                'status_sebelum' => $statusSebelum,
                'status_sesudah' => StatusPublikasi::Dipublikasikan->value,
                'catatan' => $catatan ?: 'Disetujui dan dipublikasikan.',
                'id_pengguna' => $penerbit?->id,
            ]);

            $this->buatVersi($eModul, $penerbit);

            return $eModul;
        });
    }

    /**
     * Membekukan isi E-Modul saat ini sebagai satu versi baru. Nomor versi
     * bertambah otomatis dan baris yang sudah dibuat tidak pernah diubah lagi.
     */
    public function buatVersi(EModul $eModul, ?Pengguna $penerbit = null): VersiEModul
    {
        $nomorVersi = (int) $eModul->versi()->max('nomor_versi') + 1;

        return VersiEModul::create([
            'id_e_modul' => $eModul->id,
            'nomor_versi' => $nomorVersi,
            'judul' => $eModul->judul,
            'ringkasan' => $eModul->ringkasan,
            'deskripsi' => $eModul->deskripsi,
            'capaian_pembelajaran' => $eModul->capaian_pembelajaran,
            'tujuan_pembelajaran' => $eModul->tujuan_pembelajaran,
            'pengetahuan_lokal' => $eModul->pengetahuan_lokal,
            'konsep_sains' => $eModul->konsep_sains,
            'konteks_wilayah' => $eModul->konteks_wilayah,
            'aktivitas_saintifik' => $eModul->aktivitas_saintifik,
            'nilai_karakter' => $eModul->nilai_karakter,
            'gambar_sampul' => $eModul->gambar_sampul,
            'gambar_poster' => $eModul->gambar_poster,
            'berkas_pdf' => $eModul->berkas_pdf,
            'jumlah_halaman' => $eModul->jumlah_halaman,
            'id_pengguna' => $penerbit?->id,
        ]);
    }
}
