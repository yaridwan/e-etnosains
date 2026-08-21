<?php

use App\Http\Controllers\Guru\BahanAjarController;
use App\Http\Controllers\Guru\DashboardController;
use App\Http\Controllers\Guru\EModulController;
use App\Http\Controllers\Guru\KelasBelajarController;
use App\Http\Controllers\Guru\LkpdController;
use App\Http\Controllers\Guru\MenungguVerifikasiController;
use App\Http\Controllers\Guru\ObservasiController;
use App\Http\Controllers\Guru\PengumpulanObservasiController;
use App\Http\Controllers\Guru\PosterController;
use App\Http\Controllers\Guru\ProfilController;
use App\Http\Controllers\Guru\TugasKelasController;
use App\Http\Controllers\Guru\VideoController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/guru/menunggu-verifikasi', MenungguVerifikasiController::class)->name('guru.menunggu-verifikasi');
});

Route::prefix('guru')->name('guru.')->middleware(['auth', 'verified', 'peran:guru', 'guru.terverifikasi'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::resource('e-modul', EModulController::class)->except(['show'])->parameters(['e-modul' => 'eModul']);
    Route::get('/e-modul/{eModul}/preview', [EModulController::class, 'preview'])->name('e-modul.preview');
    Route::post('/e-modul/{eModul}/ajukan', [EModulController::class, 'ajukan'])->name('e-modul.ajukan');

    Route::resource('lkpd', LkpdController::class)->except(['show']);
    Route::resource('bahan-ajar', BahanAjarController::class)->except(['show'])->parameters(['bahan-ajar' => 'bahanAjar']);
    Route::resource('video', VideoController::class)->except(['show']);
    Route::resource('poster', PosterController::class)->except(['show']);
    Route::resource('observasi', ObservasiController::class)->except(['show']);

    Route::resource('kelas', KelasBelajarController::class)->except(['edit'])->parameters(['kelas' => 'kelas']);
    Route::post('/kelas/{kelas}/konten', [KelasBelajarController::class, 'tambahKonten'])->name('kelas.tambah-konten');
    Route::delete('/kelas/{kelas}/konten/{konten}', [KelasBelajarController::class, 'hapusKonten'])->name('kelas.hapus-konten');
    Route::delete('/kelas/{kelas}/anggota/{pengguna}', [KelasBelajarController::class, 'keluarkanAnggota'])->name('kelas.keluarkan-anggota');

    Route::resource('tugas', TugasKelasController::class)->only(['index', 'create', 'store', 'show'])->parameters(['tugas' => 'tugas']);
    Route::post('/tugas/{tugas}/pengumpulan/{pengumpulan}/nilai', [TugasKelasController::class, 'nilai'])->name('tugas.nilai');

    Route::get('/pengumpulan-observasi', [PengumpulanObservasiController::class, 'index'])->name('pengumpulan-observasi.index');
    Route::get('/pengumpulan-observasi/{pengumpulanObservasi}', [PengumpulanObservasiController::class, 'show'])->name('pengumpulan-observasi.show');
    Route::post('/pengumpulan-observasi/{pengumpulanObservasi}/nilai', [PengumpulanObservasiController::class, 'nilai'])->name('pengumpulan-observasi.nilai');

    Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/kata-sandi', [ProfilController::class, 'ubahKataSandi'])->name('profil.ubah-kata-sandi');
});
