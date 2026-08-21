<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\MasukRequest;
use App\Support\CaptchaPenjumlahan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MasukController extends Controller
{
    public function create(): View
    {
        return view('autentikasi.masuk', [
            'captcha' => CaptchaPenjumlahan::soal(),
        ]);
    }

    public function store(MasukRequest $request): RedirectResponse
    {
        $pengguna = $request->autentikasi();
        $request->session()->regenerate();

        if ($pengguna->isAdministrator()) {
            return redirect()->intended(route('admin.dashboard'));
        }

        if ($pengguna->isGuru()) {
            return redirect()->intended(route('guru.dashboard'));
        }

        return redirect()->intended(route('siswa.dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('beranda');
    }
}
