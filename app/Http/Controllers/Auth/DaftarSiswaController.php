<?php

namespace App\Http\Controllers\Auth;

use App\Enums\StatusAkun;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\DaftarSiswaRequest;
use App\Models\InstansiPendidikan;
use App\Services\RegistrasiService;
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

        $pesan = $siswa->status_akun === StatusAkun::Aktif
            ? 'Pendaftaran berhasil! Anda dapat langsung masuk.'
            : 'Pendaftaran berhasil! Akun Anda akan aktif setelah disetujui Administrator.';

        return redirect()->route('masuk')->with('status', $pesan);
    }
}
