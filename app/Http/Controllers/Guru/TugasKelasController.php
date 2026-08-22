<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\KelasBelajar;
use App\Models\NilaiTugas;
use App\Models\TugasKelas;
use App\Services\EksporService;
use App\Services\NotifikasiService;
use App\Services\UploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TugasKelasController extends Controller
{
    public function index(Request $request): View
    {
        $idKelas = $request->user()->kelasBelajar()->pluck('id');

        return view('guru.tugas.index', [
            'tugas' => TugasKelas::whereIn('id_kelas_belajar', $idKelas)->with('kelasBelajar')->latest()->paginate(10),
        ]);
    }

    public function create(Request $request): View
    {
        return view('guru.tugas.form', [
            'kelasSaya' => $request->user()->kelasBelajar()->get(),
            'kelasTerpilih' => $request->integer('kelas'),
        ]);
    }

    public function store(Request $request, UploadService $upload): RedirectResponse
    {
        $data = $request->validate([
            'id_kelas_belajar' => ['required', 'exists:kelas_belajar,id'],
            'judul' => ['required', 'string', 'max:200'],
            'petunjuk' => ['nullable', 'string'],
            'tanggal_mulai' => ['nullable', 'date'],
            'batas_waktu' => ['nullable', 'date'],
            'bobot' => ['nullable', 'integer', 'min:1', 'max:100'],
            'berkas' => ['nullable', 'file', 'max:20480'],
        ]);

        $kelas = KelasBelajar::findOrFail($data['id_kelas_belajar']);
        abort_unless($kelas->id_pengguna === $request->user()->id, 403);

        if ($request->hasFile('berkas')) {
            $data['berkas'] = $upload->simpanDokumen($request->file('berkas'), 'tugas');
        }

        $tugas = TugasKelas::create($data + ['id_pengguna' => $request->user()->id, 'status' => 'dipublikasikan']);

        return redirect()->route('guru.tugas.show', $tugas)->with('status', 'Tugas berhasil dibuat.');
    }

    public function show(TugasKelas $tugas): View
    {
        $this->pastikanPemilik($tugas);
        $tugas->load(['pengumpulan.pengguna', 'pengumpulan.nilai', 'kelasBelajar']);

        return view('guru.tugas.show', ['tugas' => $tugas]);
    }

    public function nilai(Request $request, TugasKelas $tugas, int $pengumpulan, NotifikasiService $notifikasi): RedirectResponse
    {
        $this->pastikanPemilik($tugas);

        $data = $request->validate([
            'nilai' => ['required', 'numeric', 'min:0', 'max:100'],
            'catatan_guru' => ['nullable', 'string'],
        ]);

        NilaiTugas::updateOrCreate(
            ['id_pengumpulan_tugas' => $pengumpulan],
            $data + ['dinilai_oleh' => $request->user()->id, 'dinilai_pada' => now()]
        );

        $entitasPengumpulan = $tugas->pengumpulan()->find($pengumpulan);
        $entitasPengumpulan?->update(['status' => 'dinilai']);

        if ($entitasPengumpulan) {
            $notifikasi->kirim(
                $entitasPengumpulan->id_pengguna,
                'tugas',
                'Tugas Anda Telah Dinilai',
                'Tugas "'.$tugas->judul.'" mendapat nilai '.$data['nilai'].'.',
                ['id_tugas_kelas' => $tugas->id]
            );
        }

        return back()->with('status', 'Nilai berhasil disimpan.');
    }

    public function eksporNilai(Request $request, TugasKelas $tugas, EksporService $ekspor): StreamedResponse
    {
        $this->pastikanPemilik($tugas);
        $tugas->load(['pengumpulan.pengguna', 'pengumpulan.nilai']);

        $format = $request->string('format', 'xlsx')->toString();

        $baris = $tugas->pengumpulan->map(fn ($item) => [
            $item->pengguna->nama_lengkap,
            ucfirst(str_replace('_', ' ', $item->status)),
            $item->dikirim_pada?->format('d-m-Y H:i') ?? '-',
            $item->nilai->nilai ?? '-',
            $item->nilai->catatan_guru ?? '-',
        ]);

        return $ekspor->unduh(
            'Laporan Nilai Tugas: '.$tugas->judul,
            ['Siswa', 'Status', 'Dikumpulkan Pada', 'Nilai', 'Catatan Guru'],
            $baris,
            'laporan-nilai-'.Str::slug($tugas->judul),
            $format
        );
    }

    private function pastikanPemilik(TugasKelas $tugas): void
    {
        abort_unless($tugas->id_pengguna === request()->user()->id, 403);
    }
}
