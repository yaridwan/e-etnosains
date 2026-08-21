<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\PengumpulanTugas;
use App\Models\TugasKelas;
use App\Services\NotifikasiService;
use App\Services\UploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TugasKelasController extends Controller
{
    public function index(Request $request): View
    {
        $idKelas = $request->user()->kelasDiikuti()->pluck('kelas_belajar.id');

        return view('siswa.tugas.index', [
            'tugas' => TugasKelas::whereIn('id_kelas_belajar', $idKelas)
                ->with(['kelasBelajar', 'pengumpulan' => fn ($q) => $q->where('id_pengguna', $request->user()->id)])
                ->latest()->paginate(10),
        ]);
    }

    public function show(Request $request, TugasKelas $tugas): View
    {
        $this->pastikanAnggota($tugas);

        $pengumpulan = PengumpulanTugas::where('id_tugas_kelas', $tugas->id)->where('id_pengguna', $request->user()->id)->with('nilai')->first();

        return view('siswa.tugas.show', ['tugas' => $tugas, 'pengumpulan' => $pengumpulan]);
    }

    public function kumpul(Request $request, TugasKelas $tugas, UploadService $upload, NotifikasiService $notifikasi): RedirectResponse
    {
        $this->pastikanAnggota($tugas);

        $data = $request->validate([
            'catatan_siswa' => ['nullable', 'string'],
            'berkas' => ['required', 'file', 'max:20480'],
        ]);

        $data['berkas'] = $upload->simpanDokumen($request->file('berkas'), 'pengumpulan-tugas');

        PengumpulanTugas::updateOrCreate(
            ['id_tugas_kelas' => $tugas->id, 'id_pengguna' => $request->user()->id],
            $data + ['status' => 'dikirim', 'dikirim_pada' => now()]
        );

        $notifikasi->kirim(
            $tugas->id_pengguna,
            'tugas',
            'Pengumpulan Tugas Baru',
            $request->user()->nama_lengkap.' mengumpulkan tugas "'.$tugas->judul.'".',
            ['id_tugas_kelas' => $tugas->id]
        );

        return redirect()->route('siswa.tugas.show', $tugas)->with('status', 'Tugas berhasil dikumpulkan.');
    }

    private function pastikanAnggota(TugasKelas $tugas): void
    {
        abort_unless(request()->user()->kelasDiikuti()->where('kelas_belajar.id', $tugas->id_kelas_belajar)->exists(), 403);
    }
}
