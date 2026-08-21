<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\KelasBelajar;
use App\Models\NilaiTugas;
use App\Models\TugasKelas;
use App\Services\UploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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

    public function nilai(Request $request, TugasKelas $tugas, int $pengumpulan): RedirectResponse
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

        $tugas->pengumpulan()->where('id', $pengumpulan)->update(['status' => 'dinilai']);

        return back()->with('status', 'Nilai berhasil disimpan.');
    }

    private function pastikanPemilik(TugasKelas $tugas): void
    {
        abort_unless($tugas->id_pengguna === request()->user()->id, 403);
    }
}
