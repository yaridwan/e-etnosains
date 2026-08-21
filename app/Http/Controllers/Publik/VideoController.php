<?php

namespace App\Http\Controllers\Publik;

use App\Http\Controllers\Controller;
use App\Models\VideoPembelajaran;
use App\Services\AktivitasKontenService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VideoController extends Controller
{
    public function index(): View
    {
        return view('publik.video.index', [
            'video' => VideoPembelajaran::dipublikasikan()->with(['pengguna', 'mataPelajaran'])->latest('dipublikasikan_pada')->paginate(12),
        ]);
    }

    public function show(VideoPembelajaran $video, AktivitasKontenService $aktivitas, Request $request): View
    {
        abort_unless($video->status_publikasi === \App\Enums\StatusPublikasi::Dipublikasikan, 404);

        $aktivitas->catatDilihat($video, 'video_pembelajaran', $request);
        $video->load(['pengguna', 'mataPelajaran', 'topikEtnosains', 'eModul']);

        return view('publik.video.show', ['video' => $video]);
    }
}
