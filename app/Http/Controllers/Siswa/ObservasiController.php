<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\DokumentasiObservasi;
use App\Models\JawabanObservasi;
use App\Models\Observasi;
use App\Models\PengumpulanObservasi;
use App\Services\NotifikasiService;
use App\Services\UploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ObservasiController extends Controller
{
    public function index(Request $request): View
    {
        $observasi = Observasi::dipublikasikan()
            ->with(['pengumpulan' => fn ($q) => $q->where('id_pengguna', $request->user()->id)])
            ->latest()->paginate(10);

        return view('siswa.observasi.index', ['observasi' => $observasi]);
    }

    public function show(Request $request, Observasi $observasi): View
    {
        $observasi->load('butirObservasi.opsi');

        $pengumpulan = PengumpulanObservasi::where('id_observasi', $observasi->id)
            ->where('id_pengguna', $request->user()->id)
            ->with('jawaban')->first();

        return view('siswa.observasi.show', ['observasi' => $observasi, 'pengumpulan' => $pengumpulan]);
    }

    public function kirim(Request $request, Observasi $observasi, UploadService $upload, NotifikasiService $notifikasi): RedirectResponse
    {
        $data = $request->validate([
            'jawaban' => ['nullable', 'array'],
            'jawaban_opsi' => ['nullable', 'array'],
            'dokumentasi' => ['nullable', 'array'],
            'dokumentasi.*' => ['image', 'max:5120'],
        ]);

        DB::transaction(function () use ($observasi, $data, $request, $upload) {
            $pengumpulan = PengumpulanObservasi::updateOrCreate(
                ['id_observasi' => $observasi->id, 'id_pengguna' => $request->user()->id],
                ['status' => 'dikirim', 'dikirim_pada' => now()]
            );

            $pengumpulan->jawaban()->delete();

            foreach ($data['jawaban'] ?? [] as $idButir => $jawaban) {
                if (blank($jawaban)) {
                    continue;
                }

                JawabanObservasi::create([
                    'id_pengumpulan_observasi' => $pengumpulan->id,
                    'id_butir_observasi' => $idButir,
                    'jawaban_teks' => $jawaban,
                ]);
            }

            foreach ($data['jawaban_opsi'] ?? [] as $idButir => $idOpsi) {
                if (blank($idOpsi)) {
                    continue;
                }

                JawabanObservasi::create([
                    'id_pengumpulan_observasi' => $pengumpulan->id,
                    'id_butir_observasi' => $idButir,
                    'id_opsi_butir_observasi' => $idOpsi,
                ]);
            }

            foreach ($request->file('dokumentasi', []) as $berkas) {
                DokumentasiObservasi::create([
                    'id_pengumpulan_observasi' => $pengumpulan->id,
                    'berkas' => $upload->simpanGambar($berkas, 'observasi/dokumentasi'),
                ]);
            }
        });

        $notifikasi->kirim(
            $observasi->id_pengguna,
            'observasi',
            'Pengumpulan Observasi Baru',
            $request->user()->nama_lengkap.' mengirim hasil observasi "'.$observasi->judul.'".',
            ['id_observasi' => $observasi->id]
        );

        return redirect()->route('siswa.observasi.index')->with('status', 'Hasil observasi berhasil dikirim.');
    }
}
