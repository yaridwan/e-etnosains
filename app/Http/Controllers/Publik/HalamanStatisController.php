<?php

namespace App\Http\Controllers\Publik;

use App\Http\Controllers\Controller;
use App\Models\HalamanStatis;
use Illuminate\View\View;

class HalamanStatisController extends Controller
{
    public function __invoke(HalamanStatis $halaman): View
    {
        abort_unless($halaman->aktif, 404);

        return view('publik.halaman-statis', ['halaman' => $halaman]);
    }
}
