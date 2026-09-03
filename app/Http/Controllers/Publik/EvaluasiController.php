<?php

namespace App\Http\Controllers\Publik;

use App\Enums\StatusPublikasi;
use App\Http\Controllers\Controller;
use App\Models\Evaluasi;
use App\Services\AktivitasKontenService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EvaluasiController extends Controller
{
    public function index(): View
    {
        return view('publik.evaluasi.index', [
            'evaluasi' => Evaluasi::dipublikasikan()->with(['pengguna', 'mataPelajaran'])->latest('dipublikasikan_pada')->paginate(12),
        ]);
    }

    public function show(Evaluasi $evaluasi, AktivitasKontenService $aktivitas, Request $request): View
    {
        abort_unless($evaluasi->status_publikasi === StatusPublikasi::Dipublikasikan, 404);

        $aktivitas->catatDilihat($evaluasi, 'evaluasi', $request);
        $evaluasi->load(['pengguna', 'mataPelajaran', 'jenjangPendidikan', 'eModul']);

        return view('publik.evaluasi.show', ['evaluasi' => $evaluasi]);
    }

    public function unduh(Evaluasi $evaluasi, AktivitasKontenService $aktivitas, Request $request): RedirectResponse|StreamedResponse
    {
        abort_unless($evaluasi->izin_unduh && $evaluasi->berkas_pdf, 403);

        $aktivitas->catatUnduhan($evaluasi, 'evaluasi', $request);

        return Storage::disk('public')->download($evaluasi->berkas_pdf, $evaluasi->judul.'.pdf');
    }
}
