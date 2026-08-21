<x-layout-auth judul-seo="Masuk">
    <h1 class="text-xl font-bold text-slate-900">Masuk ke Akun Anda</h1>
    <p class="mt-1 text-sm text-slate-500">Selamat datang kembali di {{ pengaturan('nama_aplikasi', 'E-ETNOSAINS') }}.</p>

    <form method="POST" action="{{ route('masuk.proses') }}" class="mt-6 space-y-4">
        @csrf

        <x-input label="Email" name="email" type="email" wajib autofocus />
        <x-input label="Kata Sandi" name="kata_sandi" type="password" wajib />

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="ingat_saya" class="rounded border-slate-300 text-teal-700 focus:ring-teal-600">
                Ingat saya
            </label>
            <a href="{{ route('lupa-kata-sandi') }}" class="text-sm font-medium text-teal-700 hover:underline">Lupa kata sandi?</a>
        </div>

        <x-tombol type="submit" varian="utama" class="w-full">Masuk</x-tombol>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        Belum punya akun?
        <a href="{{ route('daftar') }}" class="font-medium text-teal-700 hover:underline">Daftar sekarang</a>
    </p>
</x-layout-auth>
