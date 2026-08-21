<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class LupaKataSandiController extends Controller
{
    public function create(): View
    {
        return view('autentikasi.lupa-kata-sandi');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Tautan atur ulang kata sandi telah dikirim ke email Anda.')
            : back()->withErrors(['email' => 'Email tidak ditemukan dalam sistem kami.']);
    }
}
