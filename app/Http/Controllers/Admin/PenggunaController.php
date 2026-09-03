<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusAkun;
use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Services\EksporService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password as AturanKataSandi;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PenggunaController extends Controller
{
    public function index(Request $request): View
    {
        return view('admin.pengguna.index', [
            'pengguna' => $this->query($request)->latest()->paginate(20)->withQueryString(),
        ]);
    }

    private function query(Request $request)
    {
        $query = Pengguna::with('peran');

        if ($request->filled('peran')) {
            $query->whereHas('peran', fn ($q) => $q->where('nama_peran', $request->string('peran')));
        }

        if ($request->filled('q')) {
            $kataKunci = $request->string('q');
            $query->where(fn ($q) => $q->where('nama_lengkap', 'like', "%{$kataKunci}%")->orWhere('email', 'like', "%{$kataKunci}%"));
        }

        return $query;
    }

    public function ekspor(Request $request, EksporService $ekspor): StreamedResponse
    {
        $format = $request->string('format', 'xlsx')->toString();

        $baris = $this->query($request)->orderBy('nama_lengkap')->get()->map(fn (Pengguna $p) => [
            $p->nama_lengkap,
            $p->email,
            $p->peran->pluck('nama_peran')->join(', '),
            $p->status_akun?->value ?? '-',
            $p->email_terverifikasi_pada?->format('d-m-Y H:i') ?? 'Belum verifikasi',
            $p->terakhir_masuk_pada?->format('d-m-Y H:i') ?? 'Belum pernah masuk',
            $p->dibuat_pada?->format('d-m-Y H:i'),
        ]);

        return $ekspor->unduh(
            'Laporan Daftar Pengguna',
            ['Nama Lengkap', 'Email', 'Peran', 'Status Akun', 'Email Terverifikasi', 'Terakhir Masuk', 'Terdaftar Pada'],
            $baris,
            'daftar-pengguna-'.now()->format('Y-m-d'),
            $format
        );
    }

    public function show(Pengguna $pengguna): View
    {
        $pengguna->load(['peran', 'profilGuru.instansiPendidikan', 'profilSiswa.instansiPendidikan', 'verifikasiGuru']);

        return view('admin.pengguna.show', ['pengguna' => $pengguna]);
    }

    public function update(Request $request, Pengguna $pengguna): RedirectResponse
    {
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', Rule::unique('pengguna', 'email')->ignore($pengguna->id)],
            'nomor_telepon' => ['nullable', 'string', 'max:20'],
        ]);

        $pengguna->update($data);

        return back()->with('status', 'Data pengguna berhasil diperbarui.');
    }

    public function ubahKataSandi(Request $request, Pengguna $pengguna): RedirectResponse
    {
        $data = $request->validate([
            'kata_sandi' => ['required', 'confirmed', AturanKataSandi::min(8)],
        ]);

        $pengguna->update(['kata_sandi' => $data['kata_sandi']]);

        return back()->with('status', 'Kata sandi pengguna berhasil diperbarui.');
    }

    public function ubahStatus(Request $request, Pengguna $pengguna): RedirectResponse
    {
        $request->validate(['status_akun' => ['required', 'in:aktif,nonaktif']]);

        if ($request->string('status_akun')->toString() === 'nonaktif' && $galat = $this->cegahAksiTerlarang($pengguna)) {
            return $galat;
        }

        $pengguna->update(['status_akun' => StatusAkun::from($request->string('status_akun')->toString())]);

        return back()->with('status', 'Status akun pengguna berhasil diperbarui.');
    }

    public function destroy(Pengguna $pengguna): RedirectResponse
    {
        if ($galat = $this->cegahAksiTerlarang($pengguna)) {
            return $galat;
        }

        $pengguna->delete();

        return redirect()->route('admin.pengguna.index')->with('status', 'Pengguna berhasil dihapus.');
    }

    private function cegahAksiTerlarang(Pengguna $pengguna): ?RedirectResponse
    {
        if ($pengguna->id === auth()->id()) {
            return back()->with('galat', 'Anda tidak dapat menonaktifkan atau menghapus akun Anda sendiri.');
        }

        return null;
    }
}
