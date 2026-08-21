<?php

namespace App\Http\Controllers\Guru;

use App\Enums\StatusPublikasi;
use App\Http\Controllers\Controller;
use App\Http\Requests\Guru\SimpanLkpdRequest;
use App\Models\EModul;
use App\Models\JenjangPendidikan;
use App\Models\Lkpd;
use App\Models\MataPelajaran;
use App\Services\UploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LkpdController extends Controller
{
    public function index(Request $request): View
    {
        return view('guru.lkpd.index', [
            'lkpd' => $request->user()->lkpd()->with('mataPelajaran')->latest()->paginate(10),
        ]);
    }

    public function create(Request $request): View
    {
        return view('guru.lkpd.form', [
            'lkpd' => new Lkpd(),
            'mataPelajaran' => MataPelajaran::orderBy('nama_mata_pelajaran')->get(),
            'jenjang' => JenjangPendidikan::orderBy('urutan')->get(),
            'eModulSaya' => $request->user()->eModul()->get(),
        ]);
    }

    public function store(SimpanLkpdRequest $request, UploadService $upload): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('berkas_pdf')) {
            $data['berkas_pdf'] = $upload->simpanDokumen($request->file('berkas_pdf'), 'lkpd');
        }
        if ($request->hasFile('gambar_sampul')) {
            $data['gambar_sampul'] = $upload->simpanGambar($request->file('gambar_sampul'), 'lkpd/sampul');
        }

        $data['izin_unduh'] = $data['izin_unduh'] ?? false;
        $data['status_publikasi'] = StatusPublikasi::Dipublikasikan;
        $data['dipublikasikan_pada'] = now();

        $request->user()->lkpd()->create($data);

        return redirect()->route('guru.lkpd.index')->with('status', 'LKPD berhasil dipublikasikan.');
    }

    public function edit(Request $request, Lkpd $lkpd): View
    {
        $this->pastikanPemilik($lkpd);

        return view('guru.lkpd.form', [
            'lkpd' => $lkpd,
            'mataPelajaran' => MataPelajaran::orderBy('nama_mata_pelajaran')->get(),
            'jenjang' => JenjangPendidikan::orderBy('urutan')->get(),
            'eModulSaya' => $request->user()->eModul()->get(),
        ]);
    }

    public function update(SimpanLkpdRequest $request, Lkpd $lkpd, UploadService $upload): RedirectResponse
    {
        $this->pastikanPemilik($lkpd);

        $data = $request->validated();

        if ($request->hasFile('berkas_pdf')) {
            $upload->hapus($lkpd->berkas_pdf);
            $data['berkas_pdf'] = $upload->simpanDokumen($request->file('berkas_pdf'), 'lkpd');
        }
        if ($request->hasFile('gambar_sampul')) {
            $upload->hapus($lkpd->gambar_sampul);
            $data['gambar_sampul'] = $upload->simpanGambar($request->file('gambar_sampul'), 'lkpd/sampul');
        }

        $data['izin_unduh'] = $data['izin_unduh'] ?? false;
        $lkpd->update($data);

        return back()->with('status', 'LKPD berhasil diperbarui.');
    }

    public function destroy(Lkpd $lkpd): RedirectResponse
    {
        $this->pastikanPemilik($lkpd);
        $lkpd->delete();

        return redirect()->route('guru.lkpd.index')->with('status', 'LKPD berhasil dihapus.');
    }

    private function pastikanPemilik(Lkpd $lkpd): void
    {
        abort_unless($lkpd->id_pengguna === request()->user()->id, 403);
    }
}
