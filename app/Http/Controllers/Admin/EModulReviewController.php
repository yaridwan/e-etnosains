<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusPublikasi;
use App\Http\Controllers\Controller;
use App\Models\AuditAktivitas;
use App\Models\CatatanPeninjauanEModul;
use App\Models\EModul;
use App\Models\RiwayatStatusEModul;
use App\Services\NotifikasiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EModulReviewController extends Controller
{
    public function index(Request $request): View
    {
        $query = EModul::with(['pengguna', 'mataPelajaran']);

        if ($request->filled('status')) {
            $query->where('status_publikasi', $request->string('status'));
        } else {
            $query->whereIn('status_publikasi', [StatusPublikasi::Diajukan, StatusPublikasi::DalamPeninjauan, StatusPublikasi::PerluPerbaikan]);
        }

        return view('admin.tinjau-e-modul.index', [
            'eModul' => $query->latest('diperbarui_pada')->paginate(15)->withQueryString(),
        ]);
    }

    public function show(EModul $eModul): View
    {
        $eModul->load(['pengguna.profilGuru', 'mataPelajaran', 'jenjangPendidikan', 'topikEtnosains', 'daerahEtnosains', 'catatanPeninjauan.pengguna', 'riwayatStatus']);

        return view('admin.tinjau-e-modul.show', ['eModul' => $eModul]);
    }

    public function setujui(EModul $eModul, Request $request, NotifikasiService $notifikasi): RedirectResponse
    {
        $request->validate(['catatan' => ['nullable', 'string']]);

        DB::transaction(function () use ($eModul, $request) {
            $statusSebelum = $eModul->status_publikasi->value;

            $eModul->update([
                'status_publikasi' => StatusPublikasi::Dipublikasikan,
                'dipublikasikan_pada' => now(),
                'catatan_reviewer' => $request->string('catatan'),
            ]);

            RiwayatStatusEModul::create([
                'id_e_modul' => $eModul->id,
                'status_sebelum' => $statusSebelum,
                'status_sesudah' => StatusPublikasi::Dipublikasikan->value,
                'catatan' => $request->string('catatan') ?: 'Disetujui dan dipublikasikan.',
                'id_pengguna' => $request->user()->id,
            ]);

            CatatanPeninjauanEModul::create([
                'id_e_modul' => $eModul->id,
                'id_pengguna' => $request->user()->id,
                'catatan' => $request->string('catatan') ?: 'Konten disetujui.',
                'keputusan' => 'disetujui',
            ]);

            AuditAktivitas::create([
                'id_pengguna' => $request->user()->id,
                'aktivitas' => 'menyetujui e-modul',
                'modul' => 'e_modul',
                'id_referensi' => $eModul->id,
                'alamat_ip' => $request->ip(),
                'agen_pengguna' => $request->userAgent(),
            ]);
        });

        $notifikasi->kirim(
            $eModul->id_pengguna,
            'e_modul',
            'E-Modul Anda Dipublikasikan',
            'E-Modul "'.$eModul->judul.'" telah disetujui dan kini tampil di portal publik.',
            ['id_e_modul' => $eModul->id]
        );

        return redirect()->route('admin.tinjau-e-modul.index')->with('status', 'E-Modul berhasil disetujui dan dipublikasikan.');
    }

    public function mintaPerbaikan(EModul $eModul, Request $request, NotifikasiService $notifikasi): RedirectResponse
    {
        $request->validate(['catatan' => ['required', 'string']]);

        DB::transaction(function () use ($eModul, $request) {
            $statusSebelum = $eModul->status_publikasi->value;

            $eModul->update([
                'status_publikasi' => StatusPublikasi::PerluPerbaikan,
                'catatan_reviewer' => $request->string('catatan'),
            ]);

            RiwayatStatusEModul::create([
                'id_e_modul' => $eModul->id,
                'status_sebelum' => $statusSebelum,
                'status_sesudah' => StatusPublikasi::PerluPerbaikan->value,
                'catatan' => $request->string('catatan'),
                'id_pengguna' => $request->user()->id,
            ]);

            CatatanPeninjauanEModul::create([
                'id_e_modul' => $eModul->id,
                'id_pengguna' => $request->user()->id,
                'catatan' => $request->string('catatan'),
                'keputusan' => 'perlu_perbaikan',
            ]);
        });

        $notifikasi->kirim(
            $eModul->id_pengguna,
            'e_modul',
            'E-Modul Perlu Perbaikan',
            'E-Modul "'.$eModul->judul.'" perlu diperbaiki. Catatan: '.$request->string('catatan'),
            ['id_e_modul' => $eModul->id]
        );

        return redirect()->route('admin.tinjau-e-modul.index')->with('status', 'Permintaan perbaikan telah dikirim ke guru.');
    }

    public function tolak(EModul $eModul, Request $request, NotifikasiService $notifikasi): RedirectResponse
    {
        $request->validate(['catatan' => ['required', 'string']]);

        DB::transaction(function () use ($eModul, $request) {
            $statusSebelum = $eModul->status_publikasi->value;

            $eModul->update([
                'status_publikasi' => StatusPublikasi::Ditolak,
                'catatan_reviewer' => $request->string('catatan'),
            ]);

            RiwayatStatusEModul::create([
                'id_e_modul' => $eModul->id,
                'status_sebelum' => $statusSebelum,
                'status_sesudah' => StatusPublikasi::Ditolak->value,
                'catatan' => $request->string('catatan'),
                'id_pengguna' => $request->user()->id,
            ]);

            CatatanPeninjauanEModul::create([
                'id_e_modul' => $eModul->id,
                'id_pengguna' => $request->user()->id,
                'catatan' => $request->string('catatan'),
                'keputusan' => 'ditolak',
            ]);
        });

        $notifikasi->kirim(
            $eModul->id_pengguna,
            'e_modul',
            'E-Modul Ditolak',
            'E-Modul "'.$eModul->judul.'" ditolak. Alasan: '.$request->string('catatan'),
            ['id_e_modul' => $eModul->id]
        );

        return redirect()->route('admin.tinjau-e-modul.index')->with('status', 'E-Modul ditolak.');
    }
}
