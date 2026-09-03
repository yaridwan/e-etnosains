<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\JenjangPendidikan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class JenjangPendidikanController extends Controller
{
    public function index(Request $request): View
    {
        $query = JenjangPendidikan::query();

        if ($request->filled('q')) {
            $query->where('nama_jenjang', 'like', '%'.$request->string('q').'%');
        }

        return view('admin.master-data.jenjang-pendidikan', [
            'data' => $query->orderBy('urutan')->paginate(15)->withQueryString(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validasi = $request->validate([
            'nama_jenjang' => ['required', 'string', 'max:100'],
            'urutan' => ['nullable', 'integer'],
        ]);

        JenjangPendidikan::create([
            'nama_jenjang' => $validasi['nama_jenjang'],
            'alamat_tautan' => Str::slug($validasi['nama_jenjang']),
            'urutan' => $validasi['urutan'] ?? 0,
        ]);

        return back()->with('status', 'Jenjang pendidikan berhasil ditambahkan.');
    }

    public function update(Request $request, JenjangPendidikan $jenjangPendidikan): RedirectResponse
    {
        $validasi = $request->validate([
            'nama_jenjang' => ['required', 'string', 'max:100'],
            'urutan' => ['nullable', 'integer'],
        ]);

        $jenjangPendidikan->update($validasi);

        return back()->with('status', 'Jenjang pendidikan berhasil diperbarui.');
    }

    public function destroy(JenjangPendidikan $jenjangPendidikan): RedirectResponse
    {
        $jenjangPendidikan->delete();

        return back()->with('status', 'Jenjang pendidikan berhasil dihapus.');
    }
}
