<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Observasi;
use App\Models\PengumpulanObservasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengumpulanObservasiController extends Controller
{
    public function index(Request $request): View
    {
        $idObservasi = $request->user()->observasi()->pluck('id');

        $query = PengumpulanObservasi::whereIn('id_observasi', $idObservasi)->with(['pengguna', 'observasi']);

        if ($request->filled('observasi')) {
            $query->where('id_observasi', $request->integer('observasi'));
        }

        return view('guru.pengumpulan-observasi.index', [
            'pengumpulan' => $query->latest()->paginate(15),
            'observasiSaya' => $request->user()->observasi()->get(),
        ]);
    }

    public function show(PengumpulanObservasi $pengumpulanObservasi): View
    {
        $this->pastikanPemilik($pengumpulanObservasi);
        $pengumpulanObservasi->load(['pengguna', 'observasi.butirObservasi.opsi', 'jawaban', 'dokumentasi']);

        return view('guru.pengumpulan-observasi.show', ['pengumpulan' => $pengumpulanObservasi]);
    }

    public function nilai(Request $request, PengumpulanObservasi $pengumpulanObservasi): RedirectResponse
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

        return back()->with('status', 'Observasi siswa berhasil dinilai.');
    }

    private function pastikanPemilik(PengumpulanObservasi $pengumpulan): void
    {
        abort_unless($pengumpulan->observasi->id_pengguna === request()->user()->id, 403);
    }
}
