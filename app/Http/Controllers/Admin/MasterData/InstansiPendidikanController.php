<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\InstansiPendidikan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InstansiPendidikanController extends Controller
{
    public function index(Request $request): View
    {
        $query = InstansiPendidikan::query();

        if ($request->filled('q')) {
            $kataKunci = $request->string('q');
            $query->where(fn ($q) => $q->where('nama_instansi', 'like', "%{$kataKunci}%")->orWhere('kota', 'like', "%{$kataKunci}%"));
        }

        if ($request->filled('jenis_instansi')) {
            $query->where('jenis_instansi', $request->string('jenis_instansi'));
        }

        return view('admin.master-data.instansi-pendidikan', [
            'data' => $query->orderBy('nama_instansi')->paginate(15)->withQueryString(),
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
