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
    public function index(): View
    {
        return view('admin.master-data.topik-etnosains', [
            'data' => TopikEtnosains::orderBy('nama_topik')->get(),
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
