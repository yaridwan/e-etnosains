<?php

use App\Http\Controllers\Publik\BerandaController;
use App\Http\Controllers\Publik\HalamanStatisController;
use App\Http\Controllers\Publik\PencarianController;
use App\Http\Controllers\Publik\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', BerandaController::class)->name('beranda');
Route::get('/pencarian', PencarianController::class)->name('pencarian');
Route::get('/halaman/{halaman:alamat_tautan}', HalamanStatisController::class)->name('halaman-statis');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', fn () => response()->view('publik.robots')->header('Content-Type', 'text/plain'))->name('robots');

require __DIR__.'/autentikasi.php';
require __DIR__.'/admin.php';
require __DIR__.'/guru.php';
require __DIR__.'/siswa.php';
require __DIR__.'/publik.php';
