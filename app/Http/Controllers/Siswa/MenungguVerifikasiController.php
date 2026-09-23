<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenungguVerifikasiController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('siswa.menunggu-verifikasi', [
            'pengguna' => $request->user(),
        ]);
    }
}
