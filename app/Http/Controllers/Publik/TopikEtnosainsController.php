<?php

namespace App\Http\Controllers\Publik;

use App\Http\Controllers\Controller;
use App\Models\TopikEtnosains;
use Illuminate\View\View;

class TopikEtnosainsController extends Controller
{
    public function index(): View
    {
        return view('publik.topik-etnosains.index', [
            'topik' => TopikEtnosains::withCount(['eModul' => fn ($q) => $q->dipublikasikan()])->orderBy('nama_topik')->get(),
        ]);
    }

    public function show(TopikEtnosains $topik): View
    {
        return view('publik.topik-etnosains.show', [
            'topik' => $topik,
            'eModul' => $topik->eModul()->dipublikasikan()
                ->with(['pengguna', 'mataPelajaran', 'jenjangPendidikan', 'topikEtnosains'])
                ->paginate(12),
        ]);
    }
}
