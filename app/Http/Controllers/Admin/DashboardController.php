<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusAkun;
use App\Enums\StatusPublikasi;
use App\Enums\StatusVerifikasiGuru;
use App\Http\Controllers\Controller;
use App\Models\BahanAjar;
use App\Models\EModul;
use App\Models\Lkpd;
use App\Models\Observasi;
use App\Models\Pengguna;
use App\Models\RiwayatUnduhan;
use App\Models\StatistikKunjungan;
use App\Models\VerifikasiGuru;
use App\Models\VideoPembelajaran;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'statistik' => [
                'total_pengguna' => Pengguna::count(),
                'guru' => Pengguna::whereHas('peran', fn ($q) => $q->where('nama_peran', 'guru'))->count(),
                'siswa' => Pengguna::whereHas('peran', fn ($q) => $q->where('nama_peran', 'siswa'))->count(),
                'e_modul' => EModul::count(),
                'lkpd' => Lkpd::count(),
                'bahan_ajar' => BahanAjar::count(),
                'video' => VideoPembelajaran::count(),
                'observasi' => Observasi::count(),
                'e_modul_menunggu' => EModul::where('status_publikasi', StatusPublikasi::Diajukan)->count(),
                'guru_menunggu' => VerifikasiGuru::where('status', StatusVerifikasiGuru::Menunggu)->count(),
                'siswa_menunggu' => Pengguna::whereHas('peran', fn ($q) => $q->where('nama_peran', 'siswa'))->where('status_akun', StatusAkun::MenungguVerifikasi)->count(),
                'total_kunjungan' => StatistikKunjungan::count(),
                'total_unduhan' => RiwayatUnduhan::count(),
            ],
            'eModulPopuler' => EModul::dipublikasikan()->orderByDesc('jumlah_dilihat')->take(5)->get(),
            'eModulMenunggu' => EModul::where('status_publikasi', StatusPublikasi::Diajukan)->with('pengguna')->latest()->take(5)->get(),
            'guruMenunggu' => VerifikasiGuru::where('status', StatusVerifikasiGuru::Menunggu)->with('pengguna')->latest()->take(5)->get(),
            'siswaMenunggu' => Pengguna::whereHas('peran', fn ($q) => $q->where('nama_peran', 'siswa'))->where('status_akun', StatusAkun::MenungguVerifikasi)->latest()->take(5)->get(),
        ]);
    }
}
