<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusPublikasi;
use App\Http\Controllers\Controller;
use App\Models\AuditAktivitas;
use App\Models\CatatanPeninjauanEModul;
use App\Models\EModul;
use App\Models\RiwayatStatusEModul;
use App\Models\VersiEModul;
use App\Services\EksporService;
use App\Services\NotifikasiService;
use App\Services\PublikasiEModulService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EModulReviewController extends Controller
{
    public function index(Request $request): View
    {
        return view('admin.tinjau-e-modul.index', [
            'eModul' => $this->query($request)->latest('diperbarui_pada')->paginate(15)->withQueryString(),
        ]);
    }

    private function query(Request $request)
    {
        $query = EModul::with(['pengguna', 'mataPelajaran']);

        if ($request->filled('q')) {
            $kataKunci = $request->string('q');
            $query->where(fn ($q) => $q
                ->where('judul', 'like', "%{$kataKunci}%")
                ->orWhereHas('pengguna', fn ($p) => $p->where('nama_lengkap', 'like', "%{$kataKunci}%")));
        }

        if ($request->filled('status')) {
            $query->where('status_publikasi', $request->string('status'));
        } else {
            $query->whereIn('status_publikasi', [
                StatusPublikasi::Diajukan, StatusPublikasi::DalamPeninjauan,
                StatusPublikasi::PerluPerbaikan, StatusPublikasi::Disetujui, StatusPublikasi::Dijadwalkan,
            ]);
        }

        return $query;
    }

    public function ekspor(Request $request, EksporService $ekspor): StreamedResponse
    {
        $format = $request->string('format', 'xlsx')->toString();

        $baris = $this->query($request)->latest('diperbarui_pada')->get()->map(fn (EModul $item) => [
            $item->judul,
            $item->pengguna->nama_lengkap,
            $item->mataPelajaran->nama_mata_pelajaran,
            $item->status_publikasi->label(),
            $item->dijadwalkan_pada?->format('d-m-Y H:i') ?? '-',
            $item->dipublikasikan_pada?->format('d-m-Y H:i') ?? '-',
            $item->diperbarui_pada?->format('d-m-Y H:i'),
        ]);

        return $ekspor->unduh(
            'Laporan E-Modul',
            ['Judul', 'Penulis', 'Mata Pelajaran', 'Status', 'Dijadwalkan Terbit', 'Dipublikasikan Pada', 'Terakhir Diperbarui'],
            $baris,
            'laporan-e-modul-'.now()->format('Y-m-d'),
            $format
        );
    }

    public function show(EModul $eModul): View
    {
        $eModul->load(['pengguna.profilGuru', 'mataPelajaran', 'jenjangPendidikan', 'topikEtnosains', 'daerahEtnosains', 'catatanPeninjauan.pengguna', 'riwayatStatus', 'versi.penerbit']);

        return view('admin.tinjau-e-modul.show', ['eModul' => $eModul]);
    }

    public function versi(EModul $eModul, VersiEModul $versi): View
    {
        abort_unless($versi->id_e_modul === $eModul->id, 404);
        $versi->load('penerbit');

        return view('admin.tinjau-e-modul.versi', ['eModul' => $eModul, 'versi' => $versi]);
    }

    public function setujui(EModul $eModul, Request $request, NotifikasiService $notifikasi, PublikasiEModulService $publikasi): RedirectResponse
    {
        $data = $request->validate([
            'catatan' => ['nullable', 'string'],
            'terbitkan_pada' => ['nullable', 'date', 'after:now'],
        ]);

        $dijadwalkan = filled($data['terbitkan_pada'] ?? null);

        DB::transaction(function () use ($eModul, $request, $data, $dijadwalkan, $publikasi) {
            if ($dijadwalkan) {
                $publikasi->jadwalkan($eModul, $request->user(), Carbon::parse($data['terbitkan_pada']), $data['catatan'] ?? null);
            } else {
                $publikasi->terbitkan($eModul, $request->user(), $data['catatan'] ?? null);
            }

            CatatanPeninjauanEModul::create([
                'id_e_modul' => $eModul->id,
                'id_pengguna' => $request->user()->id,
                'catatan' => ($data['catatan'] ?? null) ?: 'Konten disetujui.',
                'keputusan' => 'disetujui',
            ]);

            AuditAktivitas::create([
                'id_pengguna' => $request->user()->id,
                'aktivitas' => $dijadwalkan ? 'menjadwalkan terbit e-modul' : 'menyetujui e-modul',
                'modul' => 'e_modul',
                'id_referensi' => $eModul->id,
                'alamat_ip' => $request->ip(),
                'agen_pengguna' => $request->userAgent(),
            ]);
        });

        if ($dijadwalkan) {
            $notifikasi->kirim(
                $eModul->id_pengguna,
                'e_modul',
                'E-Modul Anda Dijadwalkan Terbit',
                'E-Modul "'.$eModul->judul.'" telah disetujui dan akan tampil otomatis di portal publik pada '.$eModul->dijadwalkan_pada->translatedFormat('d F Y, H:i').' WIB.',
                ['id_e_modul' => $eModul->id]
            );

            return redirect()->route('admin.tinjau-e-modul.index')->with('status', 'E-Modul berhasil disetujui dan dijadwalkan terbit.');
        }

        $notifikasi->kirim(
            $eModul->id_pengguna,
            'e_modul',
            'E-Modul Anda Dipublikasikan',
            'E-Modul "'.$eModul->judul.'" telah disetujui dan kini tampil di portal publik.',
            ['id_e_modul' => $eModul->id]
        );

        return redirect()->route('admin.tinjau-e-modul.index')->with('status', 'E-Modul berhasil disetujui dan dipublikasikan.');
    }

    public function batalkanJadwal(EModul $eModul, Request $request): RedirectResponse
    {
        abort_unless($eModul->status_publikasi === StatusPublikasi::Dijadwalkan, 422, 'E-Modul ini tidak sedang dijadwalkan.');

        DB::transaction(function () use ($eModul, $request) {
            $eModul->update([
                'status_publikasi' => StatusPublikasi::Disetujui,
                'dijadwalkan_pada' => null,
            ]);

            RiwayatStatusEModul::create([
                'id_e_modul' => $eModul->id,
                'status_sebelum' => StatusPublikasi::Dijadwalkan->value,
                'status_sesudah' => StatusPublikasi::Disetujui->value,
                'catatan' => 'Penjadwalan terbit dibatalkan oleh Administrator.',
                'id_pengguna' => $request->user()->id,
            ]);
        });

        return back()->with('status', 'Penjadwalan terbit dibatalkan. E-Modul menunggu tindakan berikutnya.');
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
