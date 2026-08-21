<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengumumanController extends Controller
{
    public function index(): View
    {
        return view('admin.website.pengumuman', ['data' => Pengumuman::latest()->get()]);
    }

    private function aturan(): array
    {
        return [
            'judul' => ['required', 'string', 'max:150'],
            'isi' => ['required', 'string'],
            'target' => ['required', 'in:umum,guru,siswa'],
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
        ];
    }

    public function store(Request $request): RedirectResponse
    {
        Pengumuman::create($request->validate($this->aturan()) + ['aktif' => $request->boolean('aktif', true)]);

        return back()->with('status', 'Pengumuman berhasil ditambahkan.');
    }

    public function update(Request $request, Pengumuman $pengumuman): RedirectResponse
    {
        $pengumuman->update($request->validate($this->aturan()) + ['aktif' => $request->boolean('aktif')]);

        return back()->with('status', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman): RedirectResponse
    {
        $pengumuman->delete();

        return back()->with('status', 'Pengumuman berhasil dihapus.');
    }
}
