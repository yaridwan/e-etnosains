<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\TopikEtnosains;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TopikEtnosainsController extends Controller
{
    public function index(Request $request): View
    {
        $query = TopikEtnosains::query();

        if ($request->filled('q')) {
            $kataKunci = $request->string('q');
            $query->where(fn ($q) => $q->where('nama_topik', 'like', "%{$kataKunci}%")->orWhere('deskripsi', 'like', "%{$kataKunci}%"));
        }

        return view('admin.master-data.topik-etnosains', [
            'data' => $query->orderBy('nama_topik')->paginate(15)->withQueryString(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validasi = $request->validate([
            'nama_topik' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        TopikEtnosains::create([
            'nama_topik' => $validasi['nama_topik'],
            'alamat_tautan' => Str::slug($validasi['nama_topik']),
            'deskripsi' => $validasi['deskripsi'] ?? null,
        ]);

        return back()->with('status', 'Topik etnosains berhasil ditambahkan.');
    }

    public function update(Request $request, TopikEtnosains $topik): RedirectResponse
    {
        $validasi = $request->validate([
            'nama_topik' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $topik->update($validasi);

        return back()->with('status', 'Topik etnosains berhasil diperbarui.');
    }

    public function destroy(TopikEtnosains $topik): RedirectResponse
    {
        $topik->delete();

        return back()->with('status', 'Topik etnosains berhasil dihapus.');
    }
}
