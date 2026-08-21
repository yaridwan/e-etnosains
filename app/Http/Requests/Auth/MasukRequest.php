<?php

namespace App\Http\Requests\Auth;

use App\Models\Pengguna;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class MasukRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'kata_sandi' => ['required', 'string'],
        ];
    }

    public function attributes(): array
    {
        return ['kata_sandi' => 'kata sandi'];
    }

    public function autentikasi(): Pengguna
    {
        $this->pastikanTidakDibatasi();

        // Auth::attempt() bawaan Laravel mengecualikan kolom kredensial dari
        // klausa WHERE hanya jika namanya mengandung kata "password", sehingga
        // tidak berlaku untuk kolom kustom "kata_sandi". Verifikasi dilakukan manual.
        $pengguna = Pengguna::where('email', $this->string('email'))->first();

        if (! $pengguna || ! Hash::check($this->string('kata_sandi'), $pengguna->kata_sandi)) {
            RateLimiter::hit($this->kunciPembatas());

            throw ValidationException::withMessages([
                'email' => 'Email atau kata sandi yang Anda masukkan salah.',
            ]);
        }

        RateLimiter::clear($this->kunciPembatas());

        Auth::login($pengguna, $this->boolean('ingat_saya'));

        $pengguna->forceFill([
            'terakhir_masuk_pada' => now(),
            'alamat_ip_terakhir' => $this->ip(),
        ])->save();

        return $pengguna;
    }

    public function pastikanTidakDibatasi(): void
    {
        if (RateLimiter::tooManyAttempts($this->kunciPembatas(), 5)) {
            event(new Lockout($this));

            $detik = RateLimiter::availableIn($this->kunciPembatas());

            throw ValidationException::withMessages([
                'email' => "Terlalu banyak percobaan masuk. Silakan coba lagi dalam {$detik} detik.",
            ]);
        }
    }

    public function kunciPembatas(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
