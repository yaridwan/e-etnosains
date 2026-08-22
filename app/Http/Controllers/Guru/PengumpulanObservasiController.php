<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\PengumpulanObservasi;
use App\Services\EksporService;
use App\Services\NotifikasiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PengumpulanObservasiController extends Controller
{
    public function index(Request $request): View
    {
        return view('guru.pengumpulan-observasi.index', [
            'pengumpulan' => $this->query($request)->latest()->paginate(15),
            'observasiSaya' => $request->user()->observasi()->get(),
        ]);
    }

    private function query(Request $request)
    {
        $idObservasi = $request->user()->observasi()->pluck('id');

        $query = PengumpulanObservasi::whereIn('id_observasi', $idObservasi)->with(['pengguna', 'observasi']);

        if ($request->filled('observasi')) {
            $query->where('id_observasi', $request->integer('observasi'));
        }

        return $query;
    }

    public function ekspor(Request $request, EksporService $ekspor): StreamedResponse
    {
        $format = $request->string('format', 'xlsx')->toString();

        $baris = $this->query($request)->latest()->get()->map(fn (PengumpulanObservasi $item) => [
            $item->observasi->judul,
            $item->pengguna->nama_lengkap,
            ucfirst(str_replace('_', ' ', $item->status)),
            $item->dikirim_pada?->format('d-m-Y H:i') ?? '-',
            $item->skor ?? '-',
            $item->catatan_guru ?? '-',
        ]);

        return $ekspor->unduh(
            'Laporan Pengumpulan Observasi',
            ['Observasi', 'Siswa', 'Status', 'Dikirim Pada', 'Skor', 'Catatan Guru'],
            $baris,
            'laporan-observasi-'.now()->format('Y-m-d'),
            $format
        );
    }

    public function show(PengumpulanObservasi $pengumpulanObservasi): View
    {
        $this->pastikanPemilik($pengumpulanObservasi);
        $pengumpulanObservasi->load(['pengguna', 'observasi.butirObservasi.opsi', 'jawaban', 'dokumentasi']);

        return view('guru.pengumpulan-observasi.show', ['pengumpulan' => $pengumpulanObservasi]);
    }

    public function nilai(Request $request, PengumpulanObservasi $pengumpulanObservasi, NotifikasiService $notifikasi): RedirectResponse
    {
        $this->pastikanPemilik($pengumpulanObservasi);

        $data = $request->validate([
            'skor' => ['required', 'integer', 'min:0', 'max:100'],
            'catatan_guru' => ['nullable', 'string'],
        ]);

        $pengumpulanObservasi->update($data + [
            'status' => 'dinilai',
            'dinilai_oleh' => $request->user()->id,
            'dinilai_pada' => now(),
        ]);

        $notifikasi->kirim(
            $pengumpulanObservasi->id_pengguna,
            'observasi',
            'Observasi Anda Telah Dinilai',
            'Observasi "'.$pengumpulanObservasi->observasi->judul.'" mendapat skor '.$data['skor'].'.',
            ['id_observasi' => $pengumpulanObservasi->id_observasi]
        );

        return back()->with('status', 'Observasi siswa berhasil dinilai.');
    }

    private function pastikanPemilik(PengumpulanObservasi $pengumpulan): void
    {
        $pengumpulan->loadMissing('observasi');

        abort_unless($pengumpulan->observasi->id_pengguna === request()->user()->id, 403);
    }
}
