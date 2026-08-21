<?php

namespace App\Http\Controllers\Publik;

use App\Http\Controllers\Controller;
use App\Models\BahanAjar;
use App\Models\EModul;
use App\Models\HalamanStatis;
use App\Models\Lkpd;
use App\Models\Observasi;
use App\Models\TopikEtnosains;
use App\Models\VideoPembelajaran;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $tautan = collect([
            ['loc' => route('beranda'), 'lastmod' => now()],
            ['loc' => route('e-modul.index'), 'lastmod' => now()],
            ['loc' => route('lkpd.index'), 'lastmod' => now()],
            ['loc' => route('bahan-ajar.index'), 'lastmod' => now()],
            ['loc' => route('video.index'), 'lastmod' => now()],
            ['loc' => route('poster.index'), 'lastmod' => now()],
            ['loc' => route('observasi.index'), 'lastmod' => now()],
            ['loc' => route('topik-etnosains.index'), 'lastmod' => now()],
            ['loc' => route('pencarian'), 'lastmod' => now()],
        ]);

        $tautan = $tautan
            ->concat(EModul::dipublikasikan()->get(['alamat_tautan', 'diperbarui_pada'])->map(fn ($item) => [
                'loc' => route('e-modul.show', $item->alamat_tautan),
                'lastmod' => $item->diperbarui_pada,
            ]))
            ->concat(Lkpd::dipublikasikan()->get(['alamat_tautan', 'diperbarui_pada'])->map(fn ($item) => [
                'loc' => route('lkpd.show', $item->alamat_tautan),
                'lastmod' => $item->diperbarui_pada,
            ]))
            ->concat(BahanAjar::dipublikasikan()->get(['alamat_tautan', 'diperbarui_pada'])->map(fn ($item) => [
                'loc' => route('bahan-ajar.show', $item->alamat_tautan),
                'lastmod' => $item->diperbarui_pada,
            ]))
            ->concat(VideoPembelajaran::dipublikasikan()->get(['alamat_tautan', 'diperbarui_pada'])->map(fn ($item) => [
                'loc' => route('video.show', $item->alamat_tautan),
                'lastmod' => $item->diperbarui_pada,
            ]))
            ->concat(Observasi::dipublikasikan()->get(['alamat_tautan', 'diperbarui_pada'])->map(fn ($item) => [
                'loc' => route('observasi.show', $item->alamat_tautan),
                'lastmod' => $item->diperbarui_pada,
            ]))
            ->concat(TopikEtnosains::all(['alamat_tautan', 'diperbarui_pada'])->map(fn ($item) => [
                'loc' => route('topik-etnosains.show', $item->alamat_tautan),
                'lastmod' => $item->diperbarui_pada,
            ]))
            ->concat(HalamanStatis::where('aktif', true)->get(['alamat_tautan', 'diperbarui_pada'])->map(fn ($item) => [
                'loc' => route('halaman-statis', $item->alamat_tautan),
                'lastmod' => $item->diperbarui_pada,
            ]));

        $xml = view('publik.sitemap', ['tautan' => $tautan])->render();

        return response($xml, 200)->header('Content-Type', 'text/xml');
    }
}
