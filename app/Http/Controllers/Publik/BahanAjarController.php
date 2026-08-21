<?php

namespace App\Http\Controllers\Publik;

use App\Enums\StatusPublikasi;
use App\Http\Controllers\Controller;
use App\Models\BahanAjar;
use App\Services\AktivitasKontenService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BahanAjarController extends Controller
{
    public function index(): View
    {
        return view('publik.bahan-ajar.index', [
            'bahanAjar' => BahanAjar::dipublikasikan()->with(['pengguna', 'mataPelajaran'])->latest('dipublikasikan_pada')->paginate(12),
        ]);
    }

    public function show(BahanAjar $bahanAjar, AktivitasKontenService $aktivitas, Request $request): View
    {
        abort_unless($bahanAjar->status_publikasi === StatusPublikasi::Dipublikasikan, 404);

        $aktivitas->catatDilihat($bahanAjar, 'bahan_ajar', $request);
        $bahanAjar->load(['pengguna', 'mataPelajaran', 'jenjangPendidikan', 'topikEtnosains']);

        return view('publik.bahan-ajar.show', ['bahanAjar' => $bahanAjar]);
    }
}
