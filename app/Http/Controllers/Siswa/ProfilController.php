<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\InstansiPendidikan;
use App\Services\UploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfilController extends Controller
{
    public function edit(Request $request): View
    {
        return view('siswa.profil.edit', [
            'siswa' => $request->user(),
            'instansi' => InstansiPendidikan::orderBy('nama_instansi')->get(),
        ]);
    }

    public function update(Request $request, UploadService $upload): RedirectResponse
    {
        $siswa = $request->user();

        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'nomor_telepon' => ['nullable', 'string', 'max:20'],
            'foto' => ['nullable', 'image', 'max:5120'],
            'kelas' => ['nullable', 'string', 'max:20'],
            'id_instansi_pendidikan' => ['nullable', 'exists:instansi_pendidikan,id'],
        ]);

        if ($request->hasFile('foto')) {
            $upload->hapus($siswa->foto);
            $data['foto'] = $upload->simpanGambar($request->file('foto'), 'profil');
        }

        $siswa->update([
            'nama_lengkap' => $data['nama_lengkap'],
            'nomor_telepon' => $data['nomor_telepon'] ?? null,
            'foto' => $data['foto'] ?? $siswa->foto,
        ]);

        $siswa->profilSiswa()->update([
            'kelas' => $data['kelas'] ?? null,
            'id_instansi_pendidikan' => $data['id_instansi_pendidikan'] ?? null,
        ]);

        return back()->with('status', 'Profil berhasil diperbarui.');
    }

    public function ubahKataSandi(Request $request): RedirectResponse
    {
        $request->validate([
            'kata_sandi_saat_ini' => ['required'],
            'kata_sandi_baru' => ['required', 'confirmed', 'min:8'],
        ]);

        if (! Hash::check($request->string('kata_sandi_saat_ini'), $request->user()->kata_sandi)) {
            return back()->withErrors(['kata_sandi_saat_ini' => 'Kata sandi saat ini tidak sesuai.']);
        }

        $request->user()->update(['kata_sandi' => $request->string('kata_sandi_baru')]);

        return back()->with('status', 'Kata sandi berhasil diperbarui.');
    }
}
