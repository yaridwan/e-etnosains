<?php

namespace App\Http\Controllers\Siswa;

use App\Enums\JenisKonten;
use App\Http\Controllers\Controller;
use App\Models\KelasBelajar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KelasBelajarController extends Controller
{
    public function index(Request $request): View
    {
        return view('siswa.kelas.index', [
            'kelas' => $request->user()->kelasDiikuti()->with('pengguna')->get(),
        ]);
    }

    public function gabung(Request $request): RedirectResponse
    {
        $request->validate(['kode_kelas' => ['required', 'string']]);

        $kelas = KelasBelajar::where('kode_kelas', strtoupper($request->string('kode_kelas')))->where('aktif', true)->first();

        if (! $kelas) {
            return back()->withErrors(['kode_kelas' => 'Kode kelas tidak ditemukan atau kelas tidak aktif.']);
        }

        if ($request->user()->kelasDiikuti()->where('kelas_belajar.id', $kelas->id)->exists()) {
            return back()->withErrors(['kode_kelas' => 'Anda sudah bergabung di kelas ini.']);
        }

        $request->user()->kelasDiikuti()->attach($kelas->id, ['bergabung_pada' => now()]);

        return redirect()->route('siswa.kelas.show', $kelas)->with('status', 'Berhasil bergabung ke kelas '.$kelas->nama_kelas.'.');
    }

    public function show(Request $request, KelasBelajar $kelas): View
    {
        abort_unless($request->user()->kelasDiikuti()->where('kelas_belajar.id', $kelas->id)->exists(), 403);

        $kelas->load(['pengguna', 'tugasKelas.pengumpulan' => fn ($q) => $q->where('id_pengguna', $request->user()->id)]);

        $konten = $kelas->kontenKelas->map(function ($item) {
            $jenis = JenisKonten::tryFrom($item->jenis_konten);

            return [
                'jenis' => $jenis?->label(),
                'model' => $jenis?->modelClass()::find($item->id_referensi),
                'jenisKonten' => $item->jenis_konten,
            ];
        })->filter(fn ($item) => $item['model']);

        return view('siswa.kelas.show', ['kelas' => $kelas, 'konten' => $konten]);
    }
}
