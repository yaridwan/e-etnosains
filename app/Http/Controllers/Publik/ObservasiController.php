<?php

namespace App\Http\Controllers\Publik;

use App\Enums\StatusPublikasi;
use App\Http\Controllers\Controller;
use App\Models\Observasi;
use Illuminate\View\View;

class ObservasiController extends Controller
{
    public function index(): View
    {
        return view('publik.observasi.index', [
            'observasi' => Observasi::dipublikasikan()->with('pengguna')->latest('dibuat_pada')->paginate(12),
        ]);
    }

    public function show(Observasi $observasi): View
    {
        abort_unless($observasi->status_publikasi === StatusPublikasi::Dipublikasikan, 404);

        $observasi->load(['pengguna', 'eModul', 'butirObservasi.opsi']);

        return view('publik.observasi.show', ['observasi' => $observasi]);
    }
}
