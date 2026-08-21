<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VerifikasiEmailController extends Controller
{
    public function notice(): View
    {
        return view('autentikasi.verifikasi-email');
    }

    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('beranda');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->route('beranda')->with('status', 'Email Anda berhasil diverifikasi.');
    }

    public function kirimUlang(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('beranda');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'Tautan verifikasi baru telah dikirim ke email Anda.');
    }
}
