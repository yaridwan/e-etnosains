<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\KelasBelajar;
use App\Models\MataPelajaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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

        return view('guru.kelas.show', [
            'kelas' => $kelas,
            'eModulSaya' => $request->user()->eModul()->get(),
            'lkpdSaya' => $request->user()->lkpd()->get(),
            'observasiSaya' => $request->user()->observasi()->get(),
        ]);
    }

    public function tambahKonten(Request $request, KelasBelajar $kelas): RedirectResponse
    {
        $this->pastikanPemilik($kelas);

        $data = $request->validate([
            'jenis_konten' => ['required', 'in:e_modul,lkpd,observasi'],
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
