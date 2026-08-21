<?php

namespace App\Http\Controllers\Guru;

use App\Enums\StatusPublikasi;
use App\Http\Controllers\Controller;
use App\Http\Requests\Guru\SimpanEModulRequest;
use App\Models\DaerahEtnosains;
use App\Models\EModul;
use App\Models\JenjangPendidikan;
use App\Models\MataPelajaran;
use App\Models\TopikEtnosains;
use App\Services\PublikasiEModulService;
use App\Services\UploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EModulController extends Controller
{
    public function index(Request $request): View
    {
        return view('guru.e-modul.index', [
            'eModul' => $request->user()->eModul()->with(['mataPelajaran', 'jenjangPendidikan'])->latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('guru.e-modul.form', [
            'eModul' => new EModul(),
            'jenjang' => JenjangPendidikan::orderBy('urutan')->get(),
            'mataPelajaran' => MataPelajaran::orderBy('nama_mata_pelajaran')->get(),
            'topik' => TopikEtnosains::orderBy('nama_topik')->get(),
            'daerah' => DaerahEtnosains::orderBy('provinsi')->get(),
        ]);
    }

    public function store(SimpanEModulRequest $request, PublikasiEModulService $publikasi, UploadService $upload): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('gambar_sampul')) {
            $data['gambar_sampul'] = $upload->simpanGambar($request->file('gambar_sampul'), 'e-modul/sampul');
        }
        if ($request->hasFile('gambar_poster')) {
            $data['gambar_poster'] = $upload->simpanGambar($request->file('gambar_poster'), 'e-modul/poster');
        }
        if ($request->hasFile('berkas_pdf')) {
            $data['berkas_pdf'] = $upload->simpanDokumen($request->file('berkas_pdf'), 'e-modul/pdf');
        }

        $eModul = $publikasi->simpanDraf($request->user(), $data);

        return redirect()->route('guru.e-modul.edit', $eModul)->with('status', 'E-Modul berhasil disimpan sebagai draf.');
    }

    public function edit(EModul $eModul): View
    {
        $this->pastikanPemilik($eModul);

        return view('guru.e-modul.form', [
            'eModul' => $eModul,
            'jenjang' => JenjangPendidikan::orderBy('urutan')->get(),
            'mataPelajaran' => MataPelajaran::orderBy('nama_mata_pelajaran')->get(),
            'topik' => TopikEtnosains::orderBy('nama_topik')->get(),
            'daerah' => DaerahEtnosains::orderBy('provinsi')->get(),
        ]);
    }

    public function update(SimpanEModulRequest $request, EModul $eModul, PublikasiEModulService $publikasi, UploadService $upload): RedirectResponse
    {
        $this->pastikanPemilik($eModul);

        $data = $request->validated();

        if ($request->hasFile('gambar_sampul')) {
            $upload->hapus($eModul->gambar_sampul);
            $data['gambar_sampul'] = $upload->simpanGambar($request->file('gambar_sampul'), 'e-modul/sampul');
        }
        if ($request->hasFile('gambar_poster')) {
            $upload->hapus($eModul->gambar_poster);
            $data['gambar_poster'] = $upload->simpanGambar($request->file('gambar_poster'), 'e-modul/poster');
        }
        if ($request->hasFile('berkas_pdf')) {
            $upload->hapus($eModul->berkas_pdf);
            $data['berkas_pdf'] = $upload->simpanDokumen($request->file('berkas_pdf'), 'e-modul/pdf');
        }

        $publikasi->perbarui($eModul, $data);

        return back()->with('status', 'E-Modul berhasil diperbarui.');
    }

    public function destroy(EModul $eModul): RedirectResponse
    {
        $this->pastikanPemilik($eModul);
        $eModul->delete();

        return redirect()->route('guru.e-modul.index')->with('status', 'E-Modul berhasil dihapus.');
    }

    public function preview(EModul $eModul): View
    {
        $this->pastikanPemilik($eModul);
        $eModul->load(['mataPelajaran', 'jenjangPendidikan', 'topikEtnosains', 'daerahEtnosains']);

        return view('guru.e-modul.preview', ['eModul' => $eModul]);
    }

    public function ajukan(EModul $eModul, PublikasiEModulService $publikasi, Request $request): RedirectResponse
    {
        $this->pastikanPemilik($eModul);

        abort_if(blank($eModul->berkas_pdf), 422, 'Unggah berkas PDF sebelum mengajukan E-Modul.');
        abort_unless(in_array($eModul->status_publikasi, [StatusPublikasi::Draf, StatusPublikasi::PerluPerbaikan]), 422);

        $publikasi->ajukan($eModul, $request->user());

        return redirect()->route('guru.e-modul.index')->with('status', 'E-Modul berhasil diajukan untuk peninjauan.');
    }

    private function pastikanPemilik(EModul $eModul): void
    {
        abort_unless($eModul->id_pengguna === request()->user()->id, 403);
    }
}
