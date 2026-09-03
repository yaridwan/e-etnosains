<?php

namespace App\Http\Controllers\Admin;

use App\Enums\JenisKonten;
use App\Http\Controllers\Controller;
use App\Models\Ulasan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ModerasiUlasanController extends Controller
{
    public function index(Request $request): View
    {
        $query = Ulasan::with('pengguna');

        if ($request->filled('q')) {
            $kataKunci = $request->string('q');
            $query->where(fn ($q) => $q
                ->where('komentar', 'like', "%{$kataKunci}%")
                ->orWhereHas('pengguna', fn ($p) => $p->where('nama_lengkap', 'like', "%{$kataKunci}%")));
        }

        if ($request->filled('status')) {
            $query->where('status_moderasi', $request->string('status'));
        }

        $ulasan = $query->latest('dibuat_pada')->paginate(20)->withQueryString();

        $ulasan->getCollection()->transform(function (Ulasan $item) {
            $jenis = JenisKonten::tryFrom($item->jenis_konten);
            $item->setAttribute('labelJenis', $jenis?->label() ?? $item->jenis_konten);
            $item->setAttribute('judulKonten', $jenis?->modelClass()::find($item->id_referensi)?->judul);

            return $item;
        });

        return view('admin.moderasi.ulasan', ['ulasan' => $ulasan]);
    }

    public function setujui(Ulasan $ulasan): RedirectResponse
    {
        $ulasan->update(['status_moderasi' => 'disetujui']);

        return back()->with('status', 'Ulasan berhasil disetujui dan kini tampil publik.');
    }

    public function tolak(Ulasan $ulasan): RedirectResponse
    {
        $ulasan->update(['status_moderasi' => 'ditolak']);

        return back()->with('status', 'Ulasan ditolak dan tidak akan tampil publik.');
    }

    public function destroy(Ulasan $ulasan): RedirectResponse
    {
        $ulasan->delete();

        return back()->with('status', 'Ulasan berhasil dihapus.');
    }
}
