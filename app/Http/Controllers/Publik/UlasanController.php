<?php

namespace App\Http\Controllers\Publik;

use App\Http\Controllers\Controller;
use App\Models\EModul;
use App\Models\Ulasan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    public function store(Request $request, EModul $eModul): RedirectResponse
    {
        abort_unless(pengaturan_aktif('ulasan_aktif', true), 403, 'Fitur ulasan sedang dinonaktifkan.');

        // Guru tidak boleh memberi ulasan pada kontennya sendiri.
        abort_if($eModul->id_pengguna === $request->user()->id, 403, 'Anda tidak dapat mengulas konten milik sendiri.');

        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'komentar' => ['nullable', 'string', 'max:1000'],
        ]);

        Ulasan::updateOrCreate(
            [
                'id_pengguna' => $request->user()->id,
                'jenis_konten' => 'e_modul',
                'id_referensi' => $eModul->id,
            ],
            $data + ['status_moderasi' => 'menunggu']
        );

        return back()->with('status', 'Terima kasih! Ulasan Anda akan tampil setelah dimoderasi Administrator.');
    }
}
