<?php

use App\Http\Controllers\Publik\BahanAjarController;
use App\Http\Controllers\Publik\EModulController;
use App\Http\Controllers\Publik\GuruProfilController;
use App\Http\Controllers\Publik\LkpdController;
use App\Http\Controllers\Publik\ObservasiController;
use App\Http\Controllers\Publik\PosterController;
use App\Http\Controllers\Publik\TopikEtnosainsController;
use App\Http\Controllers\Publik\VideoController;
use Illuminate\Support\Facades\Route;

Route::prefix('e-modul')->name('e-modul.')->group(function () {
    Route::get('/', [EModulController::class, 'index'])->name('index');
    Route::get('/{eModul:alamat_tautan}', [EModulController::class, 'show'])->name('show');
    Route::get('/{eModul:alamat_tautan}/baca', [EModulController::class, 'baca'])->name('baca');
    Route::get('/{eModul:alamat_tautan}/unduh', [EModulController::class, 'unduh'])->name('unduh');
});

Route::prefix('lkpd')->name('lkpd.')->group(function () {
    Route::get('/', [LkpdController::class, 'index'])->name('index');
    Route::get('/{lkpd:alamat_tautan}', [LkpdController::class, 'show'])->name('show');
    Route::get('/{lkpd:alamat_tautan}/unduh', [LkpdController::class, 'unduh'])->name('unduh');
});

Route::prefix('bahan-ajar')->name('bahan-ajar.')->group(function () {
    Route::get('/', [BahanAjarController::class, 'index'])->name('index');
    Route::get('/{bahanAjar:alamat_tautan}', [BahanAjarController::class, 'show'])->name('show');
});

Route::prefix('video')->name('video.')->group(function () {
    Route::get('/', [VideoController::class, 'index'])->name('index');
    Route::get('/{video:alamat_tautan}', [VideoController::class, 'show'])->name('show');
});

Route::prefix('poster')->name('poster.')->group(function () {
    Route::get('/', [PosterController::class, 'index'])->name('index');
});

Route::prefix('observasi')->name('observasi.')->group(function () {
    Route::get('/', [ObservasiController::class, 'index'])->name('index');
    Route::get('/{observasi:alamat_tautan}', [ObservasiController::class, 'show'])->name('show');
});

Route::prefix('topik-etnosains')->name('topik-etnosains.')->group(function () {
    Route::get('/', [TopikEtnosainsController::class, 'index'])->name('index');
    Route::get('/{topik:alamat_tautan}', [TopikEtnosainsController::class, 'show'])->name('show');
});

Route::get('/guru/{guru}', [GuruProfilController::class, 'show'])->name('guru.profil');
