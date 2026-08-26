<x-layout-auth judul-seo="Masuk">
    <x-lencana-ikon nama="gembok" class="mb-4" />
    <h1 class="text-xl font-bold text-slate-900 dark:text-slate-100">Masuk ke Akun Anda</h1>
    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
        Selamat datang kembali di {{ pengaturan('nama_aplikasi', 'E-ETNOSAINS') }}.
    </p>

    <form method="POST" action="{{ route('masuk.proses') }}" class="mt-6 space-y-4">
        @csrf

        <x-input label="Email" name="email" type="email" wajib autofocus autocomplete="email" />
        <x-input label="Kata Sandi" name="kata_sandi" type="password" wajib autocomplete="current-password" />

        {{-- Captcha penjumlahan: menahan pengisian otomatis oleh bot --}}
        <div>
            <label for="jawaban_captcha" class="mb-1.5 flex items-center gap-1.5 text-sm font-medium text-slate-700 dark:text-slate-300">
                <x-ikon nama="perisai" class="h-4 w-4 shrink-0 text-teal-700 dark:text-teal-400" />
                Verifikasi Keamanan <span class="text-rose-600 dark:text-rose-400">*</span>
            </label>

            <div class="flex items-stretch gap-3">
                <div class="flex shrink-0 select-none items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-4 text-base font-bold tracking-wide text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200"
                     aria-hidden="true">
                    <span>{{ $captcha['angka_pertama'] }}</span>
                    <span class="text-teal-700 dark:text-teal-400">+</span>
                    <span>{{ $captcha['angka_kedua'] }}</span>
                    <span class="text-slate-400 dark:text-slate-500">=</span>
                </div>

                <input
                    type="number"
                    name="jawaban_captcha"
                    id="jawaban_captcha"
                    inputmode="numeric"
                    autocomplete="off"
                    placeholder="?"
                    aria-label="{{ $captcha['pertanyaan'] }}"
                    @if($errors->has('jawaban_captcha')) aria-invalid="true" aria-describedby="jawaban_captcha-galat" @endif
                    class="block w-full rounded-lg border px-3.5 py-2.5 text-center text-sm font-semibold shadow-sm transition placeholder:font-normal placeholder:text-slate-400 focus:outline-none focus:ring-2 dark:bg-slate-900 dark:text-slate-100 {{ $errors->has('jawaban_captcha')
                        ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500/30 dark:border-rose-500'
                        : 'border-slate-300 focus:border-teal-600 focus:ring-teal-600/30 dark:border-slate-700 dark:focus:border-teal-500' }}"
                >
            </div>

            @error('jawaban_captcha')
                <p id="jawaban_captcha-galat" class="mt-1.5 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
            @else
                <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400">
                    Isi hasil penjumlahan di atas untuk memastikan Anda bukan robot.
                </p>
            @enderror
        </div>

        <div class="flex items-center justify-between gap-3">
            <x-checkbox name="ingat_saya">Ingat saya</x-checkbox>
            <a href="{{ route('lupa-kata-sandi') }}" class="text-sm font-medium text-teal-700 hover:underline dark:text-teal-400">
                Lupa kata sandi?
            </a>
        </div>

        <x-tombol type="submit" varian="utama" class="w-full">Masuk</x-tombol>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500 dark:text-slate-400">
        Belum punya akun?
        <a href="{{ route('daftar') }}" class="font-medium text-teal-700 hover:underline dark:text-teal-400">Daftar sekarang</a>
    </p>
</x-layout-auth>
