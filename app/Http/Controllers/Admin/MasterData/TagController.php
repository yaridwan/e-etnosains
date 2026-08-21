<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TagController extends Controller
{
    public function index(): View
    {
        return view('admin.master-data.tag', [
            'data' => Tag::orderBy('nama_tag')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validasi = $request->validate(['nama_tag' => ['required', 'string', 'max:100']]);

        Tag::create([
            'nama_tag' => $validasi['nama_tag'],
            'alamat_tautan' => Str::slug($validasi['nama_tag']),
        ]);

        return back()->with('status', 'Tag berhasil ditambahkan.');
    }

    public function update(Request $request, Tag $tag): RedirectResponse
    {
        $validasi = $request->validate(['nama_tag' => ['required', 'string', 'max:100']]);
        $tag->update($validasi);

        return back()->with('status', 'Tag berhasil diperbarui.');
    }

    public function destroy(Tag $tag): RedirectResponse
    {
        $tag->delete();

        return back()->with('status', 'Tag berhasil dihapus.');
    }
}
