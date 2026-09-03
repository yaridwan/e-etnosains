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
    public function index(Request $request): View
    {
        $query = MataPelajaran::query();

        if ($request->filled('q')) {
            $query->where('nama_mata_pelajaran', 'like', '%'.$request->string('q').'%');
        }

        return view('admin.master-data.mata-pelajaran', [
            'data' => $query->orderBy('nama_mata_pelajaran')->paginate(15)->withQueryString(),
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
