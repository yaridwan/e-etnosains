<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\InstansiPendidikan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InstansiPendidikanController extends Controller
{
    public function index(): View
    {
        return view('admin.master-data.instansi-pendidikan', [
            'data' => InstansiPendidikan::orderBy('nama_instansi')->get(),
        ]);
    }

    private function aturan(): array
    {
        return [
            'nama_instansi' => ['required', 'string', 'max:150'],
            'jenis_instansi' => ['nullable', 'string', 'max:50'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'kota' => ['nullable', 'string', 'max:100'],
            'provinsi' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function store(Request $request): RedirectResponse
    {
        InstansiPendidikan::create($request->validate($this->aturan()));

        return back()->with('status', 'Instansi pendidikan berhasil ditambahkan.');
    }

    public function update(Request $request, InstansiPendidikan $instansiPendidikan): RedirectResponse
    {
        $instansiPendidikan->update($request->validate($this->aturan()));

        return back()->with('status', 'Instansi pendidikan berhasil diperbarui.');
    }

    public function destroy(InstansiPendidikan $instansiPendidikan): RedirectResponse
    {
        $instansiPendidikan->delete();

        return back()->with('status', 'Instansi pendidikan berhasil dihapus.');
    }
}
