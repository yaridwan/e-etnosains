<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Models\HalamanStatis;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HalamanStatisController extends Controller
{
    public function index(Request $request): View
    {
        $query = HalamanStatis::query();

        if ($request->filled('q')) {
            $kataKunci = $request->string('q');
            $query->where(fn ($q) => $q->where('judul', 'like', "%{$kataKunci}%")->orWhere('konten', 'like', "%{$kataKunci}%"));
        }

        if ($request->filled('status')) {
            $query->where('aktif', $request->string('status') === 'aktif');
        }

        return view('admin.website.halaman-statis', [
            'data' => $query->orderBy('judul')->paginate(15)->withQueryString(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validasi = $request->validate([
            'judul' => ['required', 'string', 'max:150'],
            'konten' => ['required', 'string'],
        ]);

        HalamanStatis::create([
            'judul' => $validasi['judul'],
            'alamat_tautan' => Str::slug($validasi['judul']),
            'konten' => $validasi['konten'],
            'aktif' => $request->boolean('aktif', true),
        ]);

        return back()->with('status', 'Halaman statis berhasil ditambahkan.');
    }

    public function update(Request $request, HalamanStatis $halaman): RedirectResponse
    {
        $validasi = $request->validate([
            'judul' => ['required', 'string', 'max:150'],
            'konten' => ['required', 'string'],
        ]);

        $halaman->update($validasi + ['aktif' => $request->boolean('aktif')]);

        return back()->with('status', 'Halaman statis berhasil diperbarui.');
    }

    public function destroy(HalamanStatis $halaman): RedirectResponse
    {
        $halaman->delete();

        return back()->with('status', 'Halaman statis berhasil dihapus.');
    }
}
