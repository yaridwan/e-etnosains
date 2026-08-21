<?php

namespace App\Http\Controllers\Publik;

use App\Http\Controllers\Controller;
use App\Models\Lkpd;
use App\Services\AktivitasKontenService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class LkpdController extends Controller
{
    public function index(): View
    {
        return view('publik.lkpd.index', [
            'lkpd' => Lkpd::dipublikasikan()->with(['pengguna', 'mataPelajaran'])->latest('dipublikasikan_pada')->paginate(12),
        ]);
    }

    public function show(Lkpd $lkpd, AktivitasKontenService $aktivitas, Request $request): View
    {
        abort_unless($lkpd->status_publikasi === \App\Enums\StatusPublikasi::Dipublikasikan, 404);

        $aktivitas->catatDilihat($lkpd, 'lkpd', $request);
        $lkpd->load(['pengguna', 'mataPelajaran', 'jenjangPendidikan', 'eModul']);

        return view('publik.lkpd.show', ['lkpd' => $lkpd]);
    }

    public function unduh(Lkpd $lkpd, AktivitasKontenService $aktivitas, Request $request): RedirectResponse|\Symfony\Component\HttpFoundation\StreamedResponse
    {
        abort_unless($lkpd->izin_unduh && $lkpd->berkas_pdf, 403);

        $aktivitas->catatUnduhan($lkpd, 'lkpd', $request);

        return Storage::disk('public')->download($lkpd->berkas_pdf, $lkpd->judul.'.pdf');
    }
}
