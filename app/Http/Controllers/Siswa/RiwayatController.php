<?php

namespace App\Http\Controllers\Siswa;

use App\Enums\JenisKonten;
use App\Http\Controllers\Controller;
use App\Models\KemajuanBelajar;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RiwayatController extends Controller
{
    public function index(Request $request): View
    {
        $riwayat = $request->user()->kemajuanBelajar()->latest('terakhir_diakses_pada')->paginate(15)
            ->through(function (KemajuanBelajar $item) {
                $jenis = JenisKonten::tryFrom($item->jenis_konten);
                $item->setAttribute('modelKonten', $jenis?->modelClass()::find($item->id_referensi));
                $item->setAttribute('labelJenis', $jenis?->label());

                return $item;
            });

        return view('siswa.riwayat.index', ['riwayat' => $riwayat]);
    }
}
