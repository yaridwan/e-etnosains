<?php

namespace App\Http\Controllers\Guru;

use App\Enums\JenisPertanyaan;
use App\Enums\StatusPublikasi;
use App\Http\Controllers\Controller;
use App\Models\ButirObservasi;
use App\Models\Observasi;
use App\Models\OpsiButirObservasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ObservasiController extends Controller
{
    public function index(Request $request): View
    {
        return view('guru.observasi.index', [
            'observasi' => $request->user()->observasi()->withCount('pengumpulan')->latest()->paginate(10),
        ]);
    }

    public function create(Request $request): View
    {
        return view('guru.observasi.form', [
            'observasi' => new Observasi,
            'eModulSaya' => $request->user()->eModul()->get(),
            'lkpdSaya' => $request->user()->lkpd()->get(),
            'jenisPertanyaan' => JenisPertanyaan::cases(),
        ]);
    }

    private function aturan(): array
    {
        return [
            'judul' => ['required', 'string', 'max:200'],
            'id_e_modul' => ['nullable', 'exists:e_modul,id'],
            'id_lkpd' => ['nullable', 'exists:lkpd,id'],
            'deskripsi' => ['nullable', 'string'],
            'tujuan' => ['nullable', 'string'],
            'petunjuk' => ['nullable', 'string'],
            'lokasi_observasi' => ['nullable', 'string', 'max:150'],
            'durasi' => ['nullable', 'string', 'max:50'],
            'alat_dan_bahan' => ['nullable', 'string'],
            'prosedur' => ['nullable', 'string'],
            'aspek_keselamatan' => ['nullable', 'string'],
            'batas_pengumpulan' => ['nullable', 'date'],
            'butir' => ['nullable', 'array'],
            'butir.*.pertanyaan' => ['required', 'string'],
            'butir.*.tipe_pertanyaan' => ['required', 'string'],
            'butir.*.wajib' => ['nullable', 'boolean'],
            'butir.*.opsi' => ['nullable', 'array'],
        ];
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->aturan());

        $observasi = DB::transaction(function () use ($data, $request) {
            $observasi = $request->user()->observasi()->create($data + ['status_publikasi' => StatusPublikasi::Dipublikasikan]);
            $this->simpanButir($observasi, $data['butir'] ?? []);

            return $observasi;
        });

        return redirect()->route('guru.observasi.index')->with('status', 'Observasi berhasil dipublikasikan.');
    }

    public function edit(Request $request, Observasi $observasi): View
    {
        $this->pastikanPemilik($observasi);
        $observasi->load('butirObservasi.opsi');

        return view('guru.observasi.form', [
            'observasi' => $observasi,
            'eModulSaya' => $request->user()->eModul()->get(),
            'lkpdSaya' => $request->user()->lkpd()->get(),
            'jenisPertanyaan' => JenisPertanyaan::cases(),
        ]);
    }

    public function update(Request $request, Observasi $observasi): RedirectResponse
    {
        $this->pastikanPemilik($observasi);

        $data = $request->validate($this->aturan());

        DB::transaction(function () use ($observasi, $data) {
            $observasi->update($data);
            $observasi->butirObservasi()->delete();
            $this->simpanButir($observasi, $data['butir'] ?? []);
        });

        return back()->with('status', 'Observasi berhasil diperbarui.');
    }

    public function destroy(Observasi $observasi): RedirectResponse
    {
        $this->pastikanPemilik($observasi);
        $observasi->delete();

        return redirect()->route('guru.observasi.index')->with('status', 'Observasi berhasil dihapus.');
    }

    private function simpanButir(Observasi $observasi, array $butirData): void
    {
        foreach ($butirData as $urutan => $butir) {
            $entitasButir = ButirObservasi::create([
                'id_observasi' => $observasi->id,
                'pertanyaan' => $butir['pertanyaan'],
                'tipe_pertanyaan' => $butir['tipe_pertanyaan'],
                'wajib' => (bool) ($butir['wajib'] ?? false),
                'urutan' => $urutan + 1,
            ]);

            foreach ($butir['opsi'] ?? [] as $urutanOpsi => $opsi) {
                if (blank($opsi)) {
                    continue;
                }

                OpsiButirObservasi::create([
                    'id_butir_observasi' => $entitasButir->id,
                    'teks_opsi' => $opsi,
                    'urutan' => $urutanOpsi + 1,
                ]);
            }
        }
    }

    private function pastikanPemilik(Observasi $observasi): void
    {
        abort_unless($observasi->id_pengguna === request()->user()->id, 403);
    }
}
