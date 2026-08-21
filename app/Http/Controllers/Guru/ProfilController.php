<?php

namespace App\Http\Controllers\Guru;

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
        return view('guru.profil.edit', [
            'guru' => $request->user(),
            'instansi' => InstansiPendidikan::orderBy('nama_instansi')->get(),
        ]);
    }

    public function update(Request $request, UploadService $upload): RedirectResponse
    {
        $guru = $request->user();

        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'nomor_telepon' => ['required', 'string', 'max:20'],
            'foto' => ['nullable', 'image', 'max:5120'],
            'bidang_studi' => ['nullable', 'string', 'max:100'],
            'id_instansi_pendidikan' => ['nullable', 'exists:instansi_pendidikan,id'],
            'alamat' => ['nullable', 'string'],
            'bio' => ['nullable', 'string'],
        ]);

        if ($request->hasFile('foto')) {
            $upload->hapus($guru->foto);
            $data['foto'] = $upload->simpanGambar($request->file('foto'), 'profil');
        }

        $guru->update([
            'nama_lengkap' => $data['nama_lengkap'],
            'nomor_telepon' => $data['nomor_telepon'],
            'foto' => $data['foto'] ?? $guru->foto,
        ]);

        $guru->profilGuru()->update([
            'bidang_studi' => $data['bidang_studi'] ?? null,
            'id_instansi_pendidikan' => $data['id_instansi_pendidikan'] ?? null,
            'alamat' => $data['alamat'] ?? null,
            'bio' => $data['bio'] ?? null,
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
