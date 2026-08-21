<?php

namespace App\Http\Controllers\Guru;

use App\Enums\StatusPublikasi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $guru = $request->user();

        return view('guru.dashboard', [
            'statistik' => [
                'e_modul' => $guru->eModul()->count(),
                'e_modul_terbit' => $guru->eModul()->where('status_publikasi', StatusPublikasi::Dipublikasikan)->count(),
                'e_modul_menunggu' => $guru->eModul()->where('status_publikasi', StatusPublikasi::Diajukan)->count(),
                'lkpd' => $guru->lkpd()->count(),
                'observasi' => $guru->observasi()->count(),
                'video' => $guru->videoPembelajaran()->count(),
                'kelas' => $guru->kelasBelajar()->count(),
                'total_dilihat' => $guru->eModul()->sum('jumlah_dilihat'),
                'total_diunduh' => $guru->eModul()->sum('jumlah_diunduh'),
            ],
            'eModulTerbaru' => $guru->eModul()->latest()->take(5)->get(),
            'kelasSaya' => $guru->kelasBelajar()->withCount('anggota')->latest()->take(5)->get(),
        ]);
    }
}
