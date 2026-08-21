<?php

namespace App\Http\Controllers\Publik;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\View\View;

class GuruProfilController extends Controller
{
    public function show(Pengguna $guru): View
    {
        abort_unless($guru->isGuru(), 404);

        $guru->load('profilGuru.instansiPendidikan');

        return view('publik.guru.show', [
            'guru' => $guru,
            'eModul' => $guru->eModul()->dipublikasikan()
                ->with(['pengguna', 'mataPelajaran', 'jenjangPendidikan', 'topikEtnosains'])
                ->latest('dipublikasikan_pada')->paginate(9),
        ]);
    }
}
