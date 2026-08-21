<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusAkun;
use App\Enums\StatusVerifikasiGuru;
use App\Http\Controllers\Controller;
use App\Models\AuditAktivitas;
use App\Models\VerifikasiGuru;
use App\Services\NotifikasiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VerifikasiGuruController extends Controller
{
    public function index(): View
    {
        return view('admin.verifikasi-guru.index', [
            'verifikasi' => VerifikasiGuru::with(['pengguna.profilGuru.instansiPendidikan'])
                ->orderByRaw("FIELD(status, 'menunggu', 'perlu_perbaikan', 'disetujui', 'ditolak')")
                ->latest()->paginate(15),
        ]);
    }

    public function show(VerifikasiGuru $verifikasiGuru): View
    {
        $verifikasiGuru->load(['pengguna.profilGuru.instansiPendidikan']);

        return view('admin.verifikasi-guru.show', ['verifikasi' => $verifikasiGuru]);
    }

    public function setujui(VerifikasiGuru $verifikasiGuru, Request $request, NotifikasiService $notifikasi): RedirectResponse
    {
        $verifikasiGuru->update([
            'status' => StatusVerifikasiGuru::Disetujui,
            'catatan' => $request->string('catatan'),
            'diverifikasi_oleh' => $request->user()->id,
            'diverifikasi_pada' => now(),
        ]);

        $verifikasiGuru->pengguna->update(['status_akun' => StatusAkun::Aktif]);

        AuditAktivitas::create([
            'id_pengguna' => $request->user()->id,
            'aktivitas' => 'menyetujui verifikasi guru',
            'modul' => 'verifikasi_guru',
            'id_referensi' => $verifikasiGuru->id,
            'alamat_ip' => $request->ip(),
            'agen_pengguna' => $request->userAgent(),
        ]);

        $notifikasi->kirim(
            $verifikasiGuru->id_pengguna,
            'verifikasi_guru',
            'Akun Anda Telah Disetujui',
            'Selamat! Akun guru Anda telah diverifikasi Administrator dan kini dapat digunakan untuk mempublikasikan konten.'
        );

        return back()->with('status', 'Guru berhasil diverifikasi dan akun telah aktif.');
    }

    public function tolak(VerifikasiGuru $verifikasiGuru, Request $request, NotifikasiService $notifikasi): RedirectResponse
    {
        $request->validate(['catatan' => ['required', 'string']]);

        $verifikasiGuru->update([
            'status' => StatusVerifikasiGuru::Ditolak,
            'catatan' => $request->string('catatan'),
            'diverifikasi_oleh' => $request->user()->id,
            'diverifikasi_pada' => now(),
        ]);

        $verifikasiGuru->pengguna->update(['status_akun' => StatusAkun::Ditolak]);

        $notifikasi->kirim(
            $verifikasiGuru->id_pengguna,
            'verifikasi_guru',
            'Pendaftaran Anda Ditolak',
            'Alasan: '.$request->string('catatan')
        );

        return back()->with('status', 'Pendaftaran guru ditolak.');
    }

    public function mintaPerbaikan(VerifikasiGuru $verifikasiGuru, Request $request, NotifikasiService $notifikasi): RedirectResponse
    {
        $request->validate(['catatan' => ['required', 'string']]);

        $verifikasiGuru->update([
            'status' => StatusVerifikasiGuru::PerluPerbaikan,
            'catatan' => $request->string('catatan'),
            'diverifikasi_oleh' => $request->user()->id,
            'diverifikasi_pada' => now(),
        ]);

        $notifikasi->kirim(
            $verifikasiGuru->id_pengguna,
            'verifikasi_guru',
            'Perbaikan Data Diperlukan',
            'Administrator meminta perbaikan data: '.$request->string('catatan')
        );

        return back()->with('status', 'Permintaan perbaikan data telah dikirim ke guru.');
    }
}
