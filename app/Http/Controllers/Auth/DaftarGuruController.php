<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\DaftarGuruRequest;
use App\Models\InstansiPendidikan;
use App\Services\RegistrasiService;
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
        $registrasi->daftarGuru($request->validated());

        return redirect()->route('masuk')
            ->with('status', 'Pendaftaran berhasil! Akun Anda akan aktif setelah disetujui Administrator.');
    }
}
