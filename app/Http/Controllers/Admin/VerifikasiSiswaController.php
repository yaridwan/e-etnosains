<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusAkun;
use App\Http\Controllers\Controller;
use App\Models\AuditAktivitas;
use App\Models\Pengguna;
use App\Services\NotifikasiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VerifikasiSiswaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Pengguna::whereHas('peran', fn ($q) => $q->where('nama_peran', 'siswa'))
            ->with('profilSiswa.instansiPendidikan');

        if ($request->filled('q')) {
            $kataKunci = $request->string('q');
            $query->where(fn ($q) => $q
                ->where('nama_lengkap', 'like', "%{$kataKunci}%")
                ->orWhere('email', 'like', "%{$kataKunci}%"));
        }

        if ($request->string('status')->toString() === 'semua') {
            // Tidak difilter sama sekali, tampilkan seluruh siswa apa pun statusnya.
        } elseif ($request->filled('status')) {
            $query->where('status_akun', $request->string('status'));
        } else {
            $query->where('status_akun', StatusAkun::MenungguVerifikasi);
        }

        return view('admin.verifikasi-siswa.index', [
            'siswa' => $query->latest()->paginate(15)->withQueryString(),
        ]);
    }

    public function show(Pengguna $siswa): View
    {
        abort_unless($siswa->isSiswa(), 404);
        $siswa->load('profilSiswa.instansiPendidikan');

        return view('admin.verifikasi-siswa.show', ['siswa' => $siswa]);
    }

    public function setujui(Pengguna $siswa, Request $request, NotifikasiService $notifikasi): RedirectResponse
    {
        abort_unless($siswa->isSiswa(), 404);

        $siswa->update([
            'status_akun' => StatusAkun::Aktif,
            'catatan_verifikasi' => null,
        ]);

        AuditAktivitas::create([
            'id_pengguna' => $request->user()->id,
            'aktivitas' => 'menyetujui verifikasi siswa',
            'modul' => 'verifikasi_siswa',
            'id_referensi' => $siswa->id,
            'alamat_ip' => $request->ip(),
            'agen_pengguna' => $request->userAgent(),
        ]);

        $notifikasi->kirim(
            $siswa,
            'verifikasi_siswa',
            'Akun Anda Telah Disetujui',
            'Selamat! Akun siswa Anda telah diverifikasi Administrator dan kini dapat digunakan untuk masuk.'
        );

        return back()->with('status', 'Siswa berhasil diverifikasi dan akun telah aktif.');
    }

    public function tolak(Pengguna $siswa, Request $request, NotifikasiService $notifikasi): RedirectResponse
    {
        abort_unless($siswa->isSiswa(), 404);
        $request->validate(['catatan' => ['required', 'string']]);

        $siswa->update([
            'status_akun' => StatusAkun::Ditolak,
            'catatan_verifikasi' => $request->string('catatan'),
        ]);

        AuditAktivitas::create([
            'id_pengguna' => $request->user()->id,
            'aktivitas' => 'menolak verifikasi siswa',
            'modul' => 'verifikasi_siswa',
            'id_referensi' => $siswa->id,
            'alamat_ip' => $request->ip(),
            'agen_pengguna' => $request->userAgent(),
        ]);

        $notifikasi->kirim(
            $siswa,
            'verifikasi_siswa',
            'Pendaftaran Anda Ditolak',
            'Alasan: '.$request->string('catatan')
        );

        return back()->with('status', 'Pendaftaran siswa ditolak.');
    }
}
