<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as AturanKataSandi;
use Illuminate\View\View;

class ResetKataSandiController extends Controller
{
    public function create(Request $request): View
    {
        return view('autentikasi.reset-kata-sandi', [
            'token' => $request->route('token'),
            'email' => $request->string('email'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'kata_sandi' => ['required', 'confirmed', AturanKataSandi::min(8)],
        ]);

        $status = Password::reset(
            [
                'email' => $request->string('email'),
                'token' => $request->string('token'),
                'password' => $request->string('kata_sandi'),
                'password_confirmation' => $request->string('kata_sandi_confirmation'),
            ],
            function (Pengguna $pengguna, string $kataSandi) {
                $pengguna->forceFill(['kata_sandi' => $kataSandi])->setRememberToken(Str::random(60));
                $pengguna->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('masuk')->with('status', 'Kata sandi berhasil diperbarui, silakan masuk.')
            : back()->withErrors(['email' => 'Tautan atur ulang kata sandi tidak valid atau telah kedaluwarsa.']);
    }
}
