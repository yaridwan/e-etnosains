<?php

namespace App\Http\Middleware;

use App\Enums\StatusAkun;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PastikanSiswaAktif
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->status_akun !== StatusAkun::Aktif) {
            return redirect()->route('siswa.menunggu-verifikasi');
        }

        return $next($request);
    }
}
