<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanAplikasi;
use App\Services\PengaturanService;
use App\Services\UploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengaturanController extends Controller
{
    public function index(): View
    {
        return view('admin.pengaturan.index', [
            'kelompok' => PengaturanAplikasi::query()->orderBy('kunci')->get()->groupBy('kelompok'),
        ]);
    }

    public function simpan(Request $request, PengaturanService $pengaturan, UploadService $upload): RedirectResponse
    {
        $data = $request->except(['_token', '_method', 'logo_utama', 'favicon']);

        foreach ($data as $kunci => $nilai) {
            if (PengaturanAplikasi::where('kunci', $kunci)->exists()) {
                $pengaturan->simpan($kunci, is_array($nilai) ? null : $nilai);
            }
        }

        foreach (['logo_utama', 'favicon'] as $kunciBerkas) {
            if ($request->hasFile($kunciBerkas)) {
                $path = $upload->simpanGambar($request->file($kunciBerkas), 'identitas');
                $pengaturan->simpan($kunciBerkas, $path);
            }
        }

        return back()->with('status', 'Pengaturan aplikasi berhasil diperbarui.');
    }
}
