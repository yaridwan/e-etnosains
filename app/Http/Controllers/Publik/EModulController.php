<?php

namespace App\Http\Controllers\Publik;

use App\Enums\StatusPublikasi;
use App\Http\Controllers\Controller;
use App\Models\EModul;
use App\Services\AktivitasKontenService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EModulController extends Controller
{
    public function index(Request $request): View
    {
        $query = EModul::dipublikasikan()->with(['pengguna', 'mataPelajaran', 'jenjangPendidikan', 'topikEtnosains']);

        if ($request->filled('jenjang')) {
            $query->where('id_jenjang_pendidikan', $request->integer('jenjang'));
        }
        if ($request->filled('mata_pelajaran')) {
            $query->where('id_mata_pelajaran', $request->integer('mata_pelajaran'));
        }
        if ($request->filled('topik')) {
            $query->where('id_topik_etnosains', $request->integer('topik'));
        }

        return view('publik.e-modul.index', [
            'eModul' => $query->latest('dipublikasikan_pada')->paginate(12)->withQueryString(),
        ]);
    }

    public function show(EModul $eModul, AktivitasKontenService $aktivitas, Request $request): View
    {
        abort_unless($eModul->status_publikasi === StatusPublikasi::Dipublikasikan, 404);

        $aktivitas->catatDilihat($eModul, 'e_modul', $request);

        $eModul->load([
            'pengguna.profilGuru', 'mataPelajaran', 'jenjangPendidikan', 'topikEtnosains',
            'daerahEtnosains', 'lkpd' => fn ($q) => $q->dipublikasikan(),
            'video' => fn ($q) => $q->dipublikasikan(),
            'observasi' => fn ($q) => $q->dipublikasikan(),
            'poster' => fn ($q) => $q->dipublikasikan(),
            'evaluasi' => fn ($q) => $q->dipublikasikan(),
        ]);

        $ulasan = $eModul->ulasan()->disetujui()->with('pengguna')->latest('dibuat_pada')->take(10)->get();

        return view('publik.e-modul.show', [
            'eModul' => $eModul,
            'ulasan' => $ulasan,
            'rataRata' => round($ulasan->avg('rating') ?? 0, 1),
            'ulasanSaya' => $request->user()
                ? $eModul->ulasan()->where('id_pengguna', $request->user()->id)->first()
                : null,
            'serupa' => EModul::dipublikasikan()
                ->where('id', '!=', $eModul->id)
                ->where('id_mata_pelajaran', $eModul->id_mata_pelajaran)
                ->with(['pengguna', 'mataPelajaran', 'jenjangPendidikan', 'topikEtnosains'])
                ->take(4)->get(),
        ]);
    }

    public function baca(EModul $eModul): View
    {
        abort_unless($eModul->status_publikasi === StatusPublikasi::Dipublikasikan, 404);
        abort_if(blank($eModul->berkas_pdf), 404, 'Berkas PDF belum tersedia.');

        return view('publik.e-modul.baca', ['eModul' => $eModul]);
    }

    public function unduh(EModul $eModul, AktivitasKontenService $aktivitas, Request $request): RedirectResponse|StreamedResponse
    {
        abort_unless($eModul->izin_unduh, 403, 'Unduhan tidak diizinkan untuk E-Modul ini.');
        abort_if(blank($eModul->berkas_pdf), 404);

        $aktivitas->catatUnduhan($eModul, 'e_modul', $request);

        return Storage::disk('public')->download($eModul->berkas_pdf, $eModul->judul.'.pdf');
    }
}
