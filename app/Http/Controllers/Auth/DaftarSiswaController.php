<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\DaftarSiswaRequest;
use App\Models\InstansiPendidikan;
use App\Services\RegistrasiService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DaftarSiswaController extends Controller
{
    public function create(): View
    {
        return view('autentikasi.daftar-siswa', [
            'instansi' => InstansiPendidikan::orderBy('nama_instansi')->get(),
        ]);
    }

    public function store(DaftarSiswaRequest $request, RegistrasiService $registrasi): RedirectResponse
    {
        $siswa = $registrasi->daftarSiswa($request->validated());

        event(new Registered($siswa));

        return redirect()->route('masuk')
            ->with('status', 'Pendaftaran berhasil! Silakan verifikasi email Anda sebelum masuk.');
    }
}
