<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Services\NotifikasiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotifikasiController extends Controller
{
    public function index(Request $request): View
    {
        return view('notifikasi.index', [
            'notifikasi' => $request->user()->notifikasi()->paginate(20),
        ]);
    }

    public function tandaiDibaca(Notifikasi $notifikasi, NotifikasiService $layanan): RedirectResponse
    {
        abort_unless($notifikasi->id_pengguna === request()->user()->id, 403);

        $layanan->tandaiDibaca($notifikasi);

        return back();
    }

    public function tandaiSemuaDibaca(Request $request, NotifikasiService $layanan): RedirectResponse
    {
        $layanan->tandaiSemuaDibaca($request->user());

        return back()->with('status', 'Semua notifikasi ditandai telah dibaca.');
    }
}
