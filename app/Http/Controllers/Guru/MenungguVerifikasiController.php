<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenungguVerifikasiController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('guru.menunggu-verifikasi', [
            'verifikasi' => $request->user()->verifikasiGuru,
        ]);
    }
}
