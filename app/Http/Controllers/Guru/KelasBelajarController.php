<?php

namespace App\Http\Controllers\Guru;

use App\Enums\JenisKonten;
use App\Http\Controllers\Controller;
use App\Models\KelasBelajar;
use App\Models\KontenKelas;
use App\Models\MataPelajaran;
use App\Services\EksporService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class KelasBelajarController extends Controller
{
    public function index(Request $request): View
    {
        return view('guru.kelas.index', [
            'kelas' => $request->user()->kelasBelajar()->withCount('anggota')->latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('guru.kelas.form', ['mataPelajaran' => MataPelajaran::orderBy('nama_mata_pelajaran')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama_kelas' => ['required', 'string', 'max:100'],
            'id_mata_pelajaran' => ['required', 'exists:mata_pelajaran,id'],
            'tahun_ajaran' => ['nullable', 'string', 'max:20'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $kelas = $request->user()->kelasBelajar()->create($data + ['aktif' => true]);

        return redirect()->route('guru.kelas.show', $kelas)->with('status', 'Kelas belajar berhasil dibuat.');
    }

    public function show(Request $request, KelasBelajar $kelas): View
    {
        $this->pastikanPemilik($kelas);
        $kelas->load(['anggota', 'kontenKelas', 'tugasKelas']);

        $kelas->kontenKelas->each(function (KontenKelas $item) {
            $jenis = JenisKonten::tryFrom($item->jenis_konten);

            $item->setAttribute('labelJenis', $jenis?->label() ?? $item->jenis_konten);
            $item->setAttribute('judulKonten', $jenis?->modelClass()::find($item->id_referensi)?->judul);
        });

        return view('guru.kelas.show', [
            'kelas' => $kelas,
            'eModulSaya' => $request->user()->eModul()->get(),
            'lkpdSaya' => $request->user()->lkpd()->get(),
            'observasiSaya' => $request->user()->observasi()->get(),
            'evaluasiSaya' => $request->user()->evaluasi()->get(),
        ]);
    }

    public function eksporAnggota(Request $request, KelasBelajar $kelas, EksporService $ekspor): StreamedResponse
    {
        $this->pastikanPemilik($kelas);
        $kelas->load(['anggota', 'tugasKelas.pengumpulan.nilai']);

        $format = $request->string('format', 'xlsx')->toString();

        $baris = $kelas->anggota->map(function ($siswa) use ($kelas) {
            $nilaiSiswa = $kelas->tugasKelas
                ->flatMap->pengumpulan
                ->where('id_pengguna', $siswa->id)
                ->pluck('nilai.nilai')
                ->filter(fn ($n) => $n !== null);

            return [
                $siswa->nama_lengkap,
                $siswa->email,
                $siswa->pivot->bergabung_pada ? Carbon::parse($siswa->pivot->bergabung_pada)->format('d-m-Y') : '-',
                $nilaiSiswa->count().' dari '.$kelas->tugasKelas->count().' tugas',
                $nilaiSiswa->isNotEmpty() ? round($nilaiSiswa->avg(), 1) : '-',
            ];
        });

        return $ekspor->unduh(
            'Laporan Anggota Kelas: '.$kelas->nama_kelas,
            ['Nama Siswa', 'Email', 'Bergabung Pada', 'Tugas Dinilai', 'Rata-rata Nilai'],
            $baris,
            'laporan-kelas-'.Str::slug($kelas->nama_kelas),
            $format
        );
    }

    public function tambahKonten(Request $request, KelasBelajar $kelas): RedirectResponse
    {
        $this->pastikanPemilik($kelas);

        $data = $request->validate([
            'jenis_konten' => ['required', 'in:e_modul,lkpd,observasi,evaluasi'],
            'id_referensi' => ['required', 'integer'],
        ]);

        $kelas->kontenKelas()->create($data + ['urutan' => $kelas->kontenKelas()->count() + 1]);

        return back()->with('status', 'Konten berhasil ditambahkan ke kelas.');
    }

    public function hapusKonten(KelasBelajar $kelas, int $konten): RedirectResponse
    {
        $this->pastikanPemilik($kelas);
        $kelas->kontenKelas()->where('id', $konten)->delete();

        return back()->with('status', 'Konten berhasil dihapus dari kelas.');
    }

    public function keluarkanAnggota(KelasBelajar $kelas, int $pengguna): RedirectResponse
    {
        $this->pastikanPemilik($kelas);
        $kelas->anggota()->detach($pengguna);

        return back()->with('status', 'Siswa berhasil dikeluarkan dari kelas.');
    }

    public function update(Request $request, KelasBelajar $kelas): RedirectResponse
    {
        $this->pastikanPemilik($kelas);

        $data = $request->validate([
            'nama_kelas' => ['required', 'string', 'max:100'],
            'tahun_ajaran' => ['nullable', 'string', 'max:20'],
            'deskripsi' => ['nullable', 'string'],
            'aktif' => ['nullable', 'boolean'],
        ]);

        $kelas->update($data + ['aktif' => $request->boolean('aktif')]);

        return back()->with('status', 'Kelas belajar berhasil diperbarui.');
    }

    public function destroy(KelasBelajar $kelas): RedirectResponse
    {
        $this->pastikanPemilik($kelas);
        $kelas->delete();

        return redirect()->route('guru.kelas.index')->with('status', 'Kelas belajar berhasil dihapus.');
    }

    private function pastikanPemilik(KelasBelajar $kelas): void
    {
        abort_unless($kelas->id_pengguna === request()->user()->id, 403);
    }
}
