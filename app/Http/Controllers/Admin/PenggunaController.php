<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusAkun;
use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PenggunaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Pengguna::with('peran');

        if ($request->filled('peran')) {
            $query->whereHas('peran', fn ($q) => $q->where('nama_peran', $request->string('peran')));
        }

        if ($request->filled('q')) {
            $kataKunci = $request->string('q');
            $query->where(fn ($q) => $q->where('nama_lengkap', 'like', "%{$kataKunci}%")->orWhere('email', 'like', "%{$kataKunci}%"));
        }

        return view('admin.pengguna.index', [
            'pengguna' => $query->latest()->paginate(20)->withQueryString(),
        ]);
    }

    public function show(Pengguna $pengguna): View
    {
        $pengguna->load(['peran', 'profilGuru.instansiPendidikan', 'profilSiswa.instansiPendidikan', 'verifikasiGuru']);

        return view('admin.pengguna.show', ['pengguna' => $pengguna]);
    }

    public function ubahStatus(Request $request, Pengguna $pengguna): RedirectResponse
    {
        $request->validate(['status_akun' => ['required', 'in:aktif,nonaktif']]);

        $pengguna->update(['status_akun' => StatusAkun::from($request->string('status_akun')->toString())]);

        return back()->with('status', 'Status akun pengguna berhasil diperbarui.');
    }
}
