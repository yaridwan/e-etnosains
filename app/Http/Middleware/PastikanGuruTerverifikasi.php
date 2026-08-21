<?php

namespace App\Http\Middleware;

use App\Enums\StatusVerifikasiGuru;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PastikanGuruTerverifikasi
{
    public function handle(Request $request, Closure $next): Response
    {
        $pengguna = $request->user();
        $status = $pengguna?->verifikasiGuru?->status;

        if ($status !== StatusVerifikasiGuru::Disetujui) {
            return redirect()->route('guru.menunggu-verifikasi');
        }

        return $next($request);
    }
}
