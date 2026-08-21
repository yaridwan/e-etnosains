<?php

namespace App\Http\Controllers\Guru;

use App\Enums\StatusPublikasi;
use App\Http\Controllers\Controller;
use App\Models\BahanAjar;
use App\Models\JenjangPendidikan;
use App\Models\MataPelajaran;
use App\Models\TopikEtnosains;
use App\Services\UploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BahanAjarController extends Controller
{
    public function index(Request $request): View
    {
        return view('guru.bahan-ajar.index', [
            'bahanAjar' => $request->user()->bahanAjar()->with('mataPelajaran')->latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('guru.bahan-ajar.form', [
            'bahanAjar' => new BahanAjar(),
            'mataPelajaran' => MataPelajaran::orderBy('nama_mata_pelajaran')->get(),
            'jenjang' => JenjangPendidikan::orderBy('urutan')->get(),
            'topik' => TopikEtnosains::orderBy('nama_topik')->get(),
        ]);
    }

    private function aturan(): array
    {
        return [
            'judul' => ['required', 'string', 'max:200'],
            'id_mata_pelajaran' => ['required', 'exists:mata_pelajaran,id'],
            'id_jenjang_pendidikan' => ['required', 'exists:jenjang_pendidikan,id'],
            'id_topik_etnosains' => ['nullable', 'exists:topik_etnosains,id'],
            'jenis_berkas' => ['required', 'in:pdf,ppt,doc,gambar,tautan'],
            'deskripsi' => ['nullable', 'string'],
            'tautan_eksternal' => ['nullable', 'url'],
            'berkas' => ['nullable', 'file', 'max:20480'],
            'gambar_sampul' => ['nullable', 'image', 'max:5120'],
        ];
    }

    public function store(Request $request, UploadService $upload): RedirectResponse
    {
        $data = $request->validate($this->aturan());

        if ($request->hasFile('berkas')) {
            $data['berkas'] = $upload->simpanDokumen($request->file('berkas'), 'bahan-ajar');
        }
        if ($request->hasFile('gambar_sampul')) {
            $data['gambar_sampul'] = $upload->simpanGambar($request->file('gambar_sampul'), 'bahan-ajar/sampul');
        }

        $data['status_publikasi'] = StatusPublikasi::Dipublikasikan;
        $data['dipublikasikan_pada'] = now();

        $request->user()->bahanAjar()->create($data);

        return redirect()->route('guru.bahan-ajar.index')->with('status', 'Bahan ajar berhasil dipublikasikan.');
    }

    public function edit(BahanAjar $bahanAjar): View
    {
        $this->pastikanPemilik($bahanAjar);

        return view('guru.bahan-ajar.form', [
            'bahanAjar' => $bahanAjar,
            'mataPelajaran' => MataPelajaran::orderBy('nama_mata_pelajaran')->get(),
            'jenjang' => JenjangPendidikan::orderBy('urutan')->get(),
            'topik' => TopikEtnosains::orderBy('nama_topik')->get(),
        ]);
    }

    public function update(Request $request, BahanAjar $bahanAjar, UploadService $upload): RedirectResponse
    {
        $this->pastikanPemilik($bahanAjar);

        $data = $request->validate($this->aturan());

        if ($request->hasFile('berkas')) {
            $upload->hapus($bahanAjar->berkas);
            $data['berkas'] = $upload->simpanDokumen($request->file('berkas'), 'bahan-ajar');
        }
        if ($request->hasFile('gambar_sampul')) {
            $upload->hapus($bahanAjar->gambar_sampul);
            $data['gambar_sampul'] = $upload->simpanGambar($request->file('gambar_sampul'), 'bahan-ajar/sampul');
        }

        $bahanAjar->update($data);

        return back()->with('status', 'Bahan ajar berhasil diperbarui.');
    }

    public function destroy(BahanAjar $bahanAjar): RedirectResponse
    {
        $this->pastikanPemilik($bahanAjar);
        $bahanAjar->delete();

        return redirect()->route('guru.bahan-ajar.index')->with('status', 'Bahan ajar berhasil dihapus.');
    }

    private function pastikanPemilik(BahanAjar $bahanAjar): void
    {
        abort_unless($bahanAjar->id_pengguna === request()->user()->id, 403);
    }
}
