<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\DaerahEtnosains;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DaerahEtnosainsController extends Controller
{
    public function index(Request $request): View
    {
        $query = DaerahEtnosains::query();

        if ($request->filled('q')) {
            $kataKunci = $request->string('q');
            $query->where(fn ($q) => $q
                ->where('provinsi', 'like', "%{$kataKunci}%")
                ->orWhere('kabupaten_kota', 'like', "%{$kataKunci}%")
                ->orWhere('nama_kearifan_lokal', 'like', "%{$kataKunci}%"));
        }

        return view('admin.master-data.daerah-etnosains', [
            'data' => $query->orderBy('provinsi')->paginate(15)->withQueryString(),
        ]);
    }

    private function aturan(): array
    {
        return [
            'provinsi' => ['required', 'string', 'max:100'],
            'kabupaten_kota' => ['nullable', 'string', 'max:100'],
            'kecamatan' => ['nullable', 'string', 'max:100'],
            'desa_kelurahan' => ['nullable', 'string', 'max:100'],
            'nama_kearifan_lokal' => ['nullable', 'string', 'max:150'],
        ];
    }

    public function store(Request $request): RedirectResponse
    {
        DaerahEtnosains::create($request->validate($this->aturan()));

        return back()->with('status', 'Daerah etnosains berhasil ditambahkan.');
    }

    public function update(Request $request, DaerahEtnosains $daerahEtnosain): RedirectResponse
    {
        $daerahEtnosain->update($request->validate($this->aturan()));

        return back()->with('status', 'Daerah etnosains berhasil diperbarui.');
    }

    public function destroy(DaerahEtnosains $daerahEtnosain): RedirectResponse
    {
        $daerahEtnosain->delete();

        return back()->with('status', 'Daerah etnosains berhasil dihapus.');
    }
}
