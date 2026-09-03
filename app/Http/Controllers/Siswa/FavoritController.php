<?php

namespace App\Http\Controllers\Siswa;

use App\Enums\JenisKonten;
use App\Http\Controllers\Controller;
use App\Models\Favorit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FavoritController extends Controller
{
    public function index(Request $request): View
    {
        $favorit = $request->user()->favorit()->latest()->get()->map(function (Favorit $item) {
            $jenis = JenisKonten::tryFrom($item->jenis_konten);

            return ['favorit' => $item, 'jenis' => $jenis?->label(), 'model' => $jenis?->modelClass()::find($item->id_referensi)];
        })->filter(fn ($item) => $item['model']);

        return view('siswa.favorit.index', ['favorit' => $favorit]);
    }

    public function toggle(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'jenis_konten' => ['required', 'in:e_modul,lkpd,bahan_ajar,video_pembelajaran,poster,observasi,evaluasi'],
            'id_referensi' => ['required', 'integer'],
        ]);

        $favorit = Favorit::where('id_pengguna', $request->user()->id)
            ->where('jenis_konten', $data['jenis_konten'])
            ->where('id_referensi', $data['id_referensi'])
            ->first();

        if ($favorit) {
            $favorit->delete();

            return back()->with('status', 'Dihapus dari favorit.');
        }

        $request->user()->favorit()->create($data);

        return back()->with('status', 'Ditambahkan ke favorit.');
    }

    public function destroy(Favorit $favorit): RedirectResponse
    {
        abort_unless($favorit->id_pengguna === request()->user()->id, 403);
        $favorit->delete();

        return back()->with('status', 'Dihapus dari favorit.');
    }
}
