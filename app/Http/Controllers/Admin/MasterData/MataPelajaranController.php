<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MataPelajaranController extends Controller
{
    public function index(): View
    {
        return view('admin.master-data.mata-pelajaran', [
            'data' => MataPelajaran::orderBy('nama_mata_pelajaran')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validasi = $request->validate(['nama_mata_pelajaran' => ['required', 'string', 'max:100']]);

        MataPelajaran::create([
            'nama_mata_pelajaran' => $validasi['nama_mata_pelajaran'],
            'alamat_tautan' => Str::slug($validasi['nama_mata_pelajaran']),
        ]);

        return back()->with('status', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function update(Request $request, MataPelajaran $mataPelajaran): RedirectResponse
    {
        $validasi = $request->validate(['nama_mata_pelajaran' => ['required', 'string', 'max:100']]);
        $mataPelajaran->update($validasi);

        return back()->with('status', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(MataPelajaran $mataPelajaran): RedirectResponse
    {
        $mataPelajaran->delete();

        return back()->with('status', 'Mata pelajaran berhasil dihapus.');
    }
}
