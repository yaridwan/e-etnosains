<?php

namespace App\Console\Commands;

use App\Enums\StatusPublikasi;
use App\Models\EModul;
use App\Services\NotifikasiService;
use App\Services\PublikasiEModulService;
use Illuminate\Console\Command;

/**
 * Menerbitkan E-Modul yang telah disetujui Administrator dan dijadwalkan
 * terbit pada waktu tertentu. Dijalankan setiap menit lewat penjadwal
 * (lihat routes/console.php) sehingga E-Modul tampil di portal publik tepat
 * waktu tanpa Administrator perlu online saat itu.
 */
class TerbitkanEModulTerjadwal extends Command
{
    protected $signature = 'e-modul:terbitkan-terjadwal';

    protected $description = 'Menerbitkan E-Modul yang jadwal terbitnya sudah tiba';

    public function handle(PublikasiEModulService $publikasi, NotifikasiService $notifikasi): int
    {
        $eModulJatuhTempo = EModul::query()
            ->where('status_publikasi', StatusPublikasi::Dijadwalkan)
            ->whereNotNull('dijadwalkan_pada')
            ->where('dijadwalkan_pada', '<=', now())
            ->get();

        foreach ($eModulJatuhTempo as $eModul) {
            $publikasi->terbitkan($eModul, null, 'Diterbitkan otomatis sesuai jadwal.');

            $notifikasi->kirim(
                $eModul->id_pengguna,
                'e_modul',
                'E-Modul Anda Telah Terbit',
                'E-Modul "'.$eModul->judul.'" kini tampil di portal publik sesuai jadwal yang ditetapkan.',
                ['id_e_modul' => $eModul->id]
            );

            $this->info("Diterbitkan: {$eModul->judul}");
        }

        if ($eModulJatuhTempo->isEmpty()) {
            $this->comment('Tidak ada E-Modul yang jadwal terbitnya sudah tiba.');
        }

        return self::SUCCESS;
    }
}
