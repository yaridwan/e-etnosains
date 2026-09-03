<?php

use App\Http\Controllers\Admin\AuditAktivitasController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EModulReviewController;
use App\Http\Controllers\Admin\MasterData\DaerahEtnosainsController;
use App\Http\Controllers\Admin\MasterData\InstansiPendidikanController;
use App\Http\Controllers\Admin\MasterData\JenjangPendidikanController;
use App\Http\Controllers\Admin\MasterData\MataPelajaranController;
use App\Http\Controllers\Admin\MasterData\TagController;
use App\Http\Controllers\Admin\MasterData\TopikEtnosainsController;
use App\Http\Controllers\Admin\ModerasiUlasanController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\VerifikasiGuruController;
use App\Http\Controllers\Admin\Website\BannerController;
use App\Http\Controllers\Admin\Website\FaqController;
use App\Http\Controllers\Admin\Website\HalamanStatisController;
use App\Http\Controllers\Admin\Website\PengumumanController;
use App\Http\Controllers\Admin\Website\TestimoniController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'peran:administrator'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/verifikasi-guru', [VerifikasiGuruController::class, 'index'])->name('verifikasi-guru.index');
    Route::get('/verifikasi-guru/{verifikasiGuru}', [VerifikasiGuruController::class, 'show'])->name('verifikasi-guru.show');
    Route::post('/verifikasi-guru/{verifikasiGuru}/setujui', [VerifikasiGuruController::class, 'setujui'])->name('verifikasi-guru.setujui');
    Route::post('/verifikasi-guru/{verifikasiGuru}/tolak', [VerifikasiGuruController::class, 'tolak'])->name('verifikasi-guru.tolak');
    Route::post('/verifikasi-guru/{verifikasiGuru}/minta-perbaikan', [VerifikasiGuruController::class, 'mintaPerbaikan'])->name('verifikasi-guru.minta-perbaikan');

    Route::get('/tinjau-e-modul', [EModulReviewController::class, 'index'])->name('tinjau-e-modul.index');
    Route::get('/tinjau-e-modul/ekspor', [EModulReviewController::class, 'ekspor'])->name('tinjau-e-modul.ekspor');
    Route::get('/tinjau-e-modul/{eModul}', [EModulReviewController::class, 'show'])->name('tinjau-e-modul.show');
    Route::get('/tinjau-e-modul/{eModul}/versi/{versi}', [EModulReviewController::class, 'versi'])->name('tinjau-e-modul.versi');
    Route::post('/tinjau-e-modul/{eModul}/setujui', [EModulReviewController::class, 'setujui'])->name('tinjau-e-modul.setujui');
    Route::post('/tinjau-e-modul/{eModul}/batalkan-jadwal', [EModulReviewController::class, 'batalkanJadwal'])->name('tinjau-e-modul.batalkan-jadwal');
    Route::post('/tinjau-e-modul/{eModul}/tolak', [EModulReviewController::class, 'tolak'])->name('tinjau-e-modul.tolak');
    Route::post('/tinjau-e-modul/{eModul}/minta-perbaikan', [EModulReviewController::class, 'mintaPerbaikan'])->name('tinjau-e-modul.minta-perbaikan');

    Route::controller(JenjangPendidikanController::class)->prefix('jenjang-pendidikan')->name('jenjang-pendidikan.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{jenjangPendidikan}', 'update')->name('update');
        Route::delete('/{jenjangPendidikan}', 'destroy')->name('destroy');
    });

    Route::controller(MataPelajaranController::class)->prefix('mata-pelajaran')->name('mata-pelajaran.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{mataPelajaran}', 'update')->name('update');
        Route::delete('/{mataPelajaran}', 'destroy')->name('destroy');
    });

    Route::controller(TopikEtnosainsController::class)->prefix('topik-etnosains')->name('topik-etnosains.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{topik}', 'update')->name('update');
        Route::delete('/{topik}', 'destroy')->name('destroy');
    });

    Route::controller(DaerahEtnosainsController::class)->prefix('daerah-etnosains')->name('daerah-etnosains.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{daerahEtnosain}', 'update')->name('update');
        Route::delete('/{daerahEtnosain}', 'destroy')->name('destroy');
    });

    Route::controller(InstansiPendidikanController::class)->prefix('instansi-pendidikan')->name('instansi-pendidikan.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{instansiPendidikan}', 'update')->name('update');
        Route::delete('/{instansiPendidikan}', 'destroy')->name('destroy');
    });

    Route::controller(TagController::class)->prefix('tag')->name('tag.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{tag}', 'update')->name('update');
        Route::delete('/{tag}', 'destroy')->name('destroy');
    });

    Route::controller(FaqController::class)->prefix('faq')->name('faq.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{faq}', 'update')->name('update');
        Route::delete('/{faq}', 'destroy')->name('destroy');
    });

    Route::controller(TestimoniController::class)->prefix('testimoni')->name('testimoni.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{testimoni}', 'update')->name('update');
        Route::delete('/{testimoni}', 'destroy')->name('destroy');
    });

    Route::controller(BannerController::class)->prefix('banner')->name('banner.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::post('/{banner}', 'update')->name('update');
        Route::delete('/{banner}', 'destroy')->name('destroy');
    });

    Route::controller(HalamanStatisController::class)->prefix('halaman-statis')->name('halaman-statis.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{halaman}', 'update')->name('update');
        Route::delete('/{halaman}', 'destroy')->name('destroy');
    });

    Route::controller(PengumumanController::class)->prefix('pengumuman')->name('pengumuman.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{pengumuman}', 'update')->name('update');
        Route::delete('/{pengumuman}', 'destroy')->name('destroy');
    });

    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
    Route::get('/pengguna/ekspor', [PenggunaController::class, 'ekspor'])->name('pengguna.ekspor');
    Route::get('/pengguna/{pengguna}', [PenggunaController::class, 'show'])->name('pengguna.show');
    Route::put('/pengguna/{pengguna}', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::put('/pengguna/{pengguna}/kata-sandi', [PenggunaController::class, 'ubahKataSandi'])->name('pengguna.ubah-kata-sandi');
    Route::patch('/pengguna/{pengguna}/status', [PenggunaController::class, 'ubahStatus'])->name('pengguna.ubah-status');
    Route::delete('/pengguna/{pengguna}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');

    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::post('/pengaturan', [PengaturanController::class, 'simpan'])->name('pengaturan.simpan');

    Route::get('/moderasi-ulasan', [ModerasiUlasanController::class, 'index'])->name('moderasi-ulasan.index');
    Route::post('/moderasi-ulasan/{ulasan}/setujui', [ModerasiUlasanController::class, 'setujui'])->name('moderasi-ulasan.setujui');
    Route::post('/moderasi-ulasan/{ulasan}/tolak', [ModerasiUlasanController::class, 'tolak'])->name('moderasi-ulasan.tolak');
    Route::delete('/moderasi-ulasan/{ulasan}', [ModerasiUlasanController::class, 'destroy'])->name('moderasi-ulasan.destroy');

    Route::get('/audit-aktivitas', [AuditAktivitasController::class, 'index'])->name('audit-aktivitas.index');
});
