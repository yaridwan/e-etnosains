<?php

namespace App\Http\Controllers\Publik;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\EModul;
use App\Models\Faq;
use App\Models\JenjangPendidikan;
use App\Models\Lkpd;
use App\Models\MataPelajaran;
use App\Models\Observasi;
use App\Models\Pengguna;
use App\Models\Testimoni;
use App\Models\TopikEtnosains;
use App\Models\VideoPembelajaran;
use Illuminate\View\View;

class BerandaController extends Controller
{
    public function __invoke(): View
    {
        return view('publik.beranda', [
            'banner' => Banner::aktif()->get(),
            'eModulUnggulan' => EModul::dipublikasikan()->where('unggulan', true)
                ->with(['pengguna', 'mataPelajaran', 'jenjangPendidikan', 'topikEtnosains'])->latest('dipublikasikan_pada')->take(4)->get(),
            'eModulTerbaru' => EModul::dipublikasikan()
                ->with(['pengguna', 'mataPelajaran', 'jenjangPendidikan', 'topikEtnosains'])->latest('dipublikasikan_pada')->take(8)->get(),
            'topikPopuler' => TopikEtnosains::withCount(['eModul' => fn ($q) => $q->dipublikasikan()])
                ->orderByDesc('e_modul_count')->take(8)->get(),
            'lkpdTerbaru' => Lkpd::dipublikasikan()->latest('dipublikasikan_pada')->take(4)->get(),
            'observasiTerbaru' => Observasi::dipublikasikan()->latest('dibuat_pada')->take(3)->get(),
            'videoTerbaru' => VideoPembelajaran::dipublikasikan()->latest('dipublikasikan_pada')->take(3)->get(),
            'jenjang' => JenjangPendidikan::orderBy('urutan')->get(),
            'mataPelajaran' => MataPelajaran::orderBy('nama_mata_pelajaran')->get(),
            'testimoni' => Testimoni::aktif()->get(),
            'faq' => Faq::aktif()->get(),
            'statistik' => [
                'e_modul' => EModul::dipublikasikan()->count(),
                'guru' => Pengguna::whereHas('peran', fn ($q) => $q->where('nama_peran', 'guru'))->count(),
                'siswa' => Pengguna::whereHas('peran', fn ($q) => $q->where('nama_peran', 'siswa'))->count(),
                'topik' => TopikEtnosains::count(),
            ],
        ]);
    }
}
