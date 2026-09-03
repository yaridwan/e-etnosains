<?php

use App\Http\Middleware\PastikanGuruTerverifikasi;
use App\Http\Middleware\PastikanPeran;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'peran' => PastikanPeran::class,
            'guru.terverifikasi' => PastikanGuruTerverifikasi::class,
            // Rute notifikasi verifikasi email bernama "verifikasi-email.notice"
            // (bukan "verification.notice" bawaan Laravel), jadi middleware
            // "verified" harus diarahkan ke sana agar tidak 500 saat email
            // pengguna belum terverifikasi.
            'verified' => EnsureEmailIsVerified::redirectTo('verifikasi-email.notice'),
        ]);

        // Rute login bernama "masuk" (bukan "login" bawaan Laravel), jadi
        // tamu yang mengakses halaman terproteksi harus diarahkan ke sana.
        $middleware->redirectGuestsTo(fn () => route('masuk'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
