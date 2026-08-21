<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\DaerahEtnosains;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DaerahEtnosainsController extends Controller
{
    public function index(): View
    {
        return view('admin.master-data.daerah-etnosains', [
            'data' => DaerahEtnosains::orderBy('provinsi')->get(),
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
