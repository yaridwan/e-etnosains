<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\UploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BannerController extends Controller
{
    public function index(Request $request): View
    {
        $query = Banner::query();

        if ($request->filled('q')) {
            $kataKunci = $request->string('q');
            $query->where(fn ($q) => $q->where('judul', 'like', "%{$kataKunci}%")->orWhere('subjudul', 'like', "%{$kataKunci}%"));
        }

        if ($request->filled('status')) {
            $query->where('aktif', $request->string('status') === 'aktif');
        }

        return view('admin.website.banner', [
            'data' => $query->orderBy('urutan')->paginate(15)->withQueryString(),
        ]);
    }

    public function store(Request $request, UploadService $upload): RedirectResponse
    {
        $validasi = $request->validate([
            'judul' => ['required', 'string', 'max:150'],
            'subjudul' => ['nullable', 'string', 'max:255'],
            'teks_tombol' => ['nullable', 'string', 'max:50'],
            'tautan_tombol' => ['nullable', 'string', 'max:255'],
            'urutan' => ['nullable', 'integer'],
            'gambar' => ['nullable', 'image', 'max:5120'],
        ]);

        if ($request->hasFile('gambar')) {
            $validasi['gambar'] = $upload->simpanGambar($request->file('gambar'), 'banner');
        }

        Banner::create($validasi + ['aktif' => $request->boolean('aktif', true)]);

        return back()->with('status', 'Banner berhasil ditambahkan.');
    }

    public function update(Request $request, Banner $banner, UploadService $upload): RedirectResponse
    {
        $validasi = $request->validate([
            'judul' => ['required', 'string', 'max:150'],
            'subjudul' => ['nullable', 'string', 'max:255'],
            'teks_tombol' => ['nullable', 'string', 'max:50'],
            'tautan_tombol' => ['nullable', 'string', 'max:255'],
            'urutan' => ['nullable', 'integer'],
            'gambar' => ['nullable', 'image', 'max:5120'],
        ]);

        if ($request->hasFile('gambar')) {
            $upload->hapus($banner->gambar);
            $validasi['gambar'] = $upload->simpanGambar($request->file('gambar'), 'banner');
        }

        $banner->update($validasi + ['aktif' => $request->boolean('aktif')]);

        return back()->with('status', 'Banner berhasil diperbarui.');
    }

    public function destroy(Banner $banner, UploadService $upload): RedirectResponse
    {
        $upload->hapus($banner->gambar);
        $banner->delete();

        return back()->with('status', 'Banner berhasil dihapus.');
    }
}
