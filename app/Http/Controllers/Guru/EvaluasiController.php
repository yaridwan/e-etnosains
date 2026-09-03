<?php

namespace App\Http\Controllers\Guru;

use App\Enums\StatusPublikasi;
use App\Http\Controllers\Controller;
use App\Http\Requests\Guru\SimpanEvaluasiRequest;
use App\Models\Evaluasi;
use App\Models\JenjangPendidikan;
use App\Models\MataPelajaran;
use App\Services\UploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EvaluasiController extends Controller
{
    public function index(Request $request): View
    {
        return view('guru.evaluasi.index', [
            'evaluasi' => $request->user()->evaluasi()->with('mataPelajaran')->latest()->paginate(10),
        ]);
    }

    public function create(Request $request): View
    {
        return view('guru.evaluasi.form', [
            'evaluasi' => new Evaluasi(['id_e_modul' => $request->integer('e_modul') ?: null]),
            'mataPelajaran' => MataPelajaran::orderBy('nama_mata_pelajaran')->get(),
            'jenjang' => JenjangPendidikan::orderBy('urutan')->get(),
            'eModulSaya' => $request->user()->eModul()->get(),
        ]);
    }

    public function store(SimpanEvaluasiRequest $request, UploadService $upload): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('berkas_pdf')) {
            $data['berkas_pdf'] = $upload->simpanDokumen($request->file('berkas_pdf'), 'evaluasi');
        }
        if ($request->hasFile('gambar_sampul')) {
            $data['gambar_sampul'] = $upload->simpanGambar($request->file('gambar_sampul'), 'evaluasi/sampul');
        }

        $data['izin_unduh'] = $data['izin_unduh'] ?? false;
        $data['status_publikasi'] = StatusPublikasi::Dipublikasikan;
        $data['dipublikasikan_pada'] = now();

        $request->user()->evaluasi()->create($data);

        return redirect()->route('guru.evaluasi.index')->with('status', 'Evaluasi berhasil dipublikasikan.');
    }

    public function edit(Request $request, Evaluasi $evaluasi): View
    {
        $this->pastikanPemilik($evaluasi);

        return view('guru.evaluasi.form', [
            'evaluasi' => $evaluasi,
            'mataPelajaran' => MataPelajaran::orderBy('nama_mata_pelajaran')->get(),
            'jenjang' => JenjangPendidikan::orderBy('urutan')->get(),
            'eModulSaya' => $request->user()->eModul()->get(),
        ]);
    }

    public function update(SimpanEvaluasiRequest $request, Evaluasi $evaluasi, UploadService $upload): RedirectResponse
    {
        $this->pastikanPemilik($evaluasi);

        $data = $request->validated();

        if ($request->hasFile('berkas_pdf')) {
            $upload->hapus($evaluasi->berkas_pdf);
            $data['berkas_pdf'] = $upload->simpanDokumen($request->file('berkas_pdf'), 'evaluasi');
        }
        if ($request->hasFile('gambar_sampul')) {
            $upload->hapus($evaluasi->gambar_sampul);
            $data['gambar_sampul'] = $upload->simpanGambar($request->file('gambar_sampul'), 'evaluasi/sampul');
        }

        $data['izin_unduh'] = $data['izin_unduh'] ?? false;
        $evaluasi->update($data);

        return back()->with('status', 'Evaluasi berhasil diperbarui.');
    }

    public function destroy(Evaluasi $evaluasi): RedirectResponse
    {
        $this->pastikanPemilik($evaluasi);
        $evaluasi->delete();

        return redirect()->route('guru.evaluasi.index')->with('status', 'Evaluasi berhasil dihapus.');
    }

    private function pastikanPemilik(Evaluasi $evaluasi): void
    {
        abort_unless($evaluasi->id_pengguna === request()->user()->id, 403);
    }
}
