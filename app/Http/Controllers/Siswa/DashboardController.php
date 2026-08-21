<?php

namespace App\Http\Controllers\Siswa;

use App\Enums\JenisKonten;
use App\Http\Controllers\Controller;
use App\Models\KemajuanBelajar;
use App\Models\Pengumuman;
use App\Models\TugasKelas;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $siswa = $request->user();

        $idKelasSiswa = $siswa->kelasDiikuti()->pluck('kelas_belajar.id');
        $jumlahTugas = TugasKelas::whereIn('id_kelas_belajar', $idKelasSiswa)->count();

        return view('siswa.dashboard', [
            'statistik' => [
                'e_modul_dipelajari' => $siswa->kemajuanBelajar()->where('jenis_konten', 'e_modul')->count(),
                'e_modul_selesai' => $siswa->kemajuanBelajar()->where('jenis_konten', 'e_modul')->where('status', 'selesai')->count(),
                'observasi_selesai' => $siswa->pengumpulanObservasi()->where('status', 'dinilai')->count(),
                'kelas' => $idKelasSiswa->count(),
                'tugas_belum' => max(0, $jumlahTugas - $siswa->pengumpulanTugas()->count()),
            ],
            'kelasSaya' => $siswa->kelasDiikuti()->take(5)->get(),
            'kemajuanTerbaru' => $siswa->kemajuanBelajar()
                ->latest('terakhir_diakses_pada')->take(5)->get()
                ->map(function (KemajuanBelajar $item) {
                    $jenis = JenisKonten::tryFrom($item->jenis_konten);
                    $konten = $jenis?->modelClass()::find($item->id_referensi);

                    $item->setAttribute('judulKonten', $konten?->judul);
                    $item->setAttribute('labelJenis', $jenis?->label());
                    $item->setAttribute('tautanKonten', $konten && $jenis === JenisKonten::EModul
                        ? route('e-modul.show', $konten)
                        : null);

                    return $item;
                }),
            'pengumumanAktif' => Pengumuman::aktif()->untukPeran('siswa')->latest()->take(3)->get(),
        ]);
    }
}
