<?php

namespace App\Http\Controllers\Publik;

use App\Http\Controllers\Controller;
use App\Models\EModul;
use App\Models\JenjangPendidikan;
use App\Models\LogPencarian;
use App\Models\MataPelajaran;
use App\Models\TopikEtnosains;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PencarianController extends Controller
{
    public function __invoke(Request $request): View
    {
        $kataKunci = $request->string('q')->toString();

        $query = EModul::dipublikasikan()->with(['pengguna', 'mataPelajaran', 'jenjangPendidikan', 'topikEtnosains']);

        if ($kataKunci !== '') {
            $query->where(function ($q) use ($kataKunci) {
                $q->where('judul', 'like', "%{$kataKunci}%")
                    ->orWhere('kata_kunci', 'like', "%{$kataKunci}%")
                    ->orWhere('ringkasan', 'like', "%{$kataKunci}%");
            });
        }

        if ($request->filled('jenjang')) {
            $query->where('id_jenjang_pendidikan', $request->integer('jenjang'));
        }

        if ($request->filled('mata_pelajaran')) {
            $query->where('id_mata_pelajaran', $request->integer('mata_pelajaran'));
        }

        if ($request->filled('topik')) {
            $query->where('id_topik_etnosains', $request->integer('topik'));
        }

        match ($request->string('urutkan')->toString()) {
            'terpopuler' => $query->orderByDesc('jumlah_dilihat'),
            default => $query->latest('dipublikasikan_pada'),
        };

        $hasil = $query->paginate(12)->withQueryString();

        if ($kataKunci !== '') {
            LogPencarian::create([
                'id_pengguna' => $request->user()?->id,
                'kata_kunci' => $kataKunci,
                'jumlah_hasil' => $hasil->total(),
            ]);
        }

        return view('publik.pencarian', [
            'hasil' => $hasil,
            'kataKunci' => $kataKunci,
            'jenjang' => JenjangPendidikan::orderBy('urutan')->get(),
            'mataPelajaran' => MataPelajaran::orderBy('nama_mata_pelajaran')->get(),
            'topik' => TopikEtnosains::orderBy('nama_topik')->get(),
        ]);
    }
}
