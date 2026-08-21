<?php

use App\Http\Controllers\Siswa\DashboardController;
use App\Http\Controllers\Siswa\FavoritController;
use App\Http\Controllers\Siswa\KelasBelajarController;
use App\Http\Controllers\Siswa\ObservasiController;
use App\Http\Controllers\Siswa\ProfilController;
use App\Http\Controllers\Siswa\RiwayatController;
use App\Http\Controllers\Siswa\TugasKelasController;
use Illuminate\Support\Facades\Route;

Route::prefix('siswa')->name('siswa.')->middleware(['auth', 'verified', 'peran:siswa'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/kelas', [KelasBelajarController::class, 'index'])->name('kelas.index');
    Route::post('/kelas/gabung', [KelasBelajarController::class, 'gabung'])->name('kelas.gabung');
    Route::get('/kelas/{kelas}', [KelasBelajarController::class, 'show'])->name('kelas.show');

    Route::get('/observasi', [ObservasiController::class, 'index'])->name('observasi.index');
    Route::get('/observasi/{observasi}', [ObservasiController::class, 'show'])->name('observasi.show');
    Route::post('/observasi/{observasi}/kirim', [ObservasiController::class, 'kirim'])->name('observasi.kirim');

    Route::get('/tugas', [TugasKelasController::class, 'index'])->name('tugas.index');
    Route::get('/tugas/{tugas}', [TugasKelasController::class, 'show'])->name('tugas.show');
    Route::post('/tugas/{tugas}/kumpul', [TugasKelasController::class, 'kumpul'])->name('tugas.kumpul');

    Route::get('/favorit', [FavoritController::class, 'index'])->name('favorit.index');
    Route::post('/favorit/toggle', [FavoritController::class, 'toggle'])->name('favorit.toggle');
    Route::delete('/favorit/{favorit}', [FavoritController::class, 'destroy'])->name('favorit.destroy');

    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');

    Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/kata-sandi', [ProfilController::class, 'ubahKataSandi'])->name('profil.ubah-kata-sandi');
});
