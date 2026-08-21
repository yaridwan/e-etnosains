<?php

use App\Http\Controllers\Auth\DaftarController;
use App\Http\Controllers\Auth\DaftarGuruController;
use App\Http\Controllers\Auth\DaftarSiswaController;
use App\Http\Controllers\Auth\LupaKataSandiController;
use App\Http\Controllers\Auth\MasukController;
use App\Http\Controllers\Auth\ResetKataSandiController;
use App\Http\Controllers\Auth\VerifikasiEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/masuk', [MasukController::class, 'create'])->name('masuk');
    Route::post('/masuk', [MasukController::class, 'store'])->name('masuk.proses');

    Route::get('/daftar', [DaftarController::class, 'create'])->name('daftar');
    Route::get('/daftar/guru', [DaftarGuruController::class, 'create'])->name('daftar.guru');
    Route::post('/daftar/guru', [DaftarGuruController::class, 'store'])->name('daftar.guru.proses');
    Route::get('/daftar/siswa', [DaftarSiswaController::class, 'create'])->name('daftar.siswa');
    Route::post('/daftar/siswa', [DaftarSiswaController::class, 'store'])->name('daftar.siswa.proses');

    Route::get('/lupa-kata-sandi', [LupaKataSandiController::class, 'create'])->name('lupa-kata-sandi');
    Route::post('/lupa-kata-sandi', [LupaKataSandiController::class, 'store'])->name('lupa-kata-sandi.proses');
    Route::get('/reset-kata-sandi/{token}', [ResetKataSandiController::class, 'create'])->name('reset-kata-sandi');
    Route::post('/reset-kata-sandi', [ResetKataSandiController::class, 'store'])->name('reset-kata-sandi.proses');
});

Route::middleware('auth')->group(function () {
    Route::post('/keluar', [MasukController::class, 'destroy'])->name('keluar');

    Route::get('/verifikasi-email', [VerifikasiEmailController::class, 'notice'])->name('verifikasi-email.notice');
    Route::get('/verifikasi-email/{id}/{hash}', [VerifikasiEmailController::class, 'verify'])
        ->middleware('signed')
        ->name('verification.verify');
    Route::post('/verifikasi-email/kirim-ulang', [VerifikasiEmailController::class, 'kirimUlang'])
        ->middleware('throttle:6,1')
        ->name('verifikasi-email.kirim-ulang');
});
