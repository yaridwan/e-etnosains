<?php

namespace App\Http\Controllers\Guru;

use App\Enums\StatusPublikasi;
use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\TopikEtnosains;
use App\Models\VideoPembelajaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VideoController extends Controller
{
    public function index(Request $request): View
    {
        return view('guru.video.index', [
            'video' => $request->user()->videoPembelajaran()->with('mataPelajaran')->latest()->paginate(10),
        ]);
    }

    public function create(Request $request): View
    {
        return view('guru.video.form', [
            'video' => new VideoPembelajaran,
            'mataPelajaran' => MataPelajaran::orderBy('nama_mata_pelajaran')->get(),
            'topik' => TopikEtnosains::orderBy('nama_topik')->get(),
            'eModulSaya' => $request->user()->eModul()->get(),
        ]);
    }

    private function aturan(): array
    {
        return [
            'judul' => ['required', 'string', 'max:200'],
            'id_mata_pelajaran' => ['required', 'exists:mata_pelajaran,id'],
            'id_topik_etnosains' => ['nullable', 'exists:topik_etnosains,id'],
            'id_e_modul' => ['nullable', 'exists:e_modul,id'],
            'deskripsi' => ['nullable', 'string'],
            'url_video' => ['required', 'url'],
        ];
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->aturan());

        $idYoutube = VideoPembelajaran::ekstrakIdYoutube($data['url_video']);
        if (! $idYoutube) {
            return back()->withErrors(['url_video' => 'URL YouTube tidak valid.'])->withInput();
        }

        $data['id_youtube'] = $idYoutube;
        $data['status_publikasi'] = StatusPublikasi::Dipublikasikan;
        $data['dipublikasikan_pada'] = now();

        $request->user()->videoPembelajaran()->create($data);

        return redirect()->route('guru.video.index')->with('status', 'Video pembelajaran berhasil dipublikasikan.');
    }

    public function edit(Request $request, VideoPembelajaran $video): View
    {
        $this->pastikanPemilik($video);

        return view('guru.video.form', [
            'video' => $video,
            'mataPelajaran' => MataPelajaran::orderBy('nama_mata_pelajaran')->get(),
            'topik' => TopikEtnosains::orderBy('nama_topik')->get(),
            'eModulSaya' => $request->user()->eModul()->get(),
        ]);
    }

    public function update(Request $request, VideoPembelajaran $video): RedirectResponse
    {
        $this->pastikanPemilik($video);

        $data = $request->validate($this->aturan());

        $idYoutube = VideoPembelajaran::ekstrakIdYoutube($data['url_video']);
        if (! $idYoutube) {
            return back()->withErrors(['url_video' => 'URL YouTube tidak valid.'])->withInput();
        }
        $data['id_youtube'] = $idYoutube;

        $video->update($data);

        return back()->with('status', 'Video pembelajaran berhasil diperbarui.');
    }

    public function destroy(VideoPembelajaran $video): RedirectResponse
    {
        $this->pastikanPemilik($video);
        $video->delete();

        return redirect()->route('guru.video.index')->with('status', 'Video pembelajaran berhasil dihapus.');
    }

    private function pastikanPemilik(VideoPembelajaran $video): void
    {
        abort_unless($video->id_pengguna === request()->user()->id, 403);
    }
}
