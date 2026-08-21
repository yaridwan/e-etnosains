<?php

namespace App\Http\Controllers\Guru;

use App\Enums\StatusPublikasi;
use App\Http\Controllers\Controller;
use App\Models\Poster;
use App\Services\UploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PosterController extends Controller
{
    public function index(Request $request): View
    {
        return view('guru.poster.index', [
            'poster' => $request->user()->poster()->latest()->paginate(10),
        ]);
    }

    public function create(Request $request): View
    {
        return view('guru.poster.form', [
            'poster' => new Poster(['id_e_modul' => $request->integer('e_modul') ?: null]),
            'eModulSaya' => $request->user()->eModul()->get(),
        ]);
    }

    public function store(Request $request, UploadService $upload): RedirectResponse
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'max:200'],
            'id_e_modul' => ['nullable', 'exists:e_modul,id'],
            'deskripsi' => ['nullable', 'string'],
            'gambar' => ['required', 'image', 'max:5120'],
        ]);

        $data['gambar'] = $upload->simpanGambar($request->file('gambar'), 'poster');
        $data['status_publikasi'] = StatusPublikasi::Dipublikasikan;
        $data['dipublikasikan_pada'] = now();

        $request->user()->poster()->create($data);

        return redirect()->route('guru.poster.index')->with('status', 'Poster berhasil dipublikasikan.');
    }

    public function edit(Request $request, Poster $poster): View
    {
        $this->pastikanPemilik($poster);

        return view('guru.poster.form', ['poster' => $poster, 'eModulSaya' => $request->user()->eModul()->get()]);
    }

    public function update(Request $request, Poster $poster, UploadService $upload): RedirectResponse
    {
        $this->pastikanPemilik($poster);

        $data = $request->validate([
            'judul' => ['required', 'string', 'max:200'],
            'id_e_modul' => ['nullable', 'exists:e_modul,id'],
            'deskripsi' => ['nullable', 'string'],
            'gambar' => ['nullable', 'image', 'max:5120'],
        ]);

        if ($request->hasFile('gambar')) {
            $upload->hapus($poster->gambar);
            $data['gambar'] = $upload->simpanGambar($request->file('gambar'), 'poster');
        }

        $poster->update($data);

        return back()->with('status', 'Poster berhasil diperbarui.');
    }

    public function destroy(Poster $poster): RedirectResponse
    {
        $this->pastikanPemilik($poster);
        $poster->delete();

        return redirect()->route('guru.poster.index')->with('status', 'Poster berhasil dihapus.');
    }

    private function pastikanPemilik(Poster $poster): void
    {
        abort_unless($poster->id_pengguna === request()->user()->id, 403);
    }
}
