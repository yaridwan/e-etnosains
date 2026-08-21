<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\DaftarGuruRequest;
use App\Models\InstansiPendidikan;
use App\Services\RegistrasiService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DaftarGuruController extends Controller
{
    public function create(): View
    {
        return view('autentikasi.daftar-guru', [
            'instansi' => InstansiPendidikan::orderBy('nama_instansi')->get(),
        ]);
    }

    public function store(DaftarGuruRequest $request, RegistrasiService $registrasi): RedirectResponse
    {
        $guru = $registrasi->daftarGuru($request->validated());

        event(new Registered($guru));

        return redirect()->route('masuk')
            ->with('status', 'Pendaftaran berhasil! Silakan verifikasi email Anda, akun akan aktif setelah disetujui Administrator.');
    }
}
