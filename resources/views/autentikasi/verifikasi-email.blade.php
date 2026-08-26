<x-layout-auth judul-seo="Verifikasi Email">
    <x-lencana-ikon nama="amplop" warna="sky" class="mb-4" />
    <h1 class="text-xl font-bold text-slate-900 dark:text-slate-100">Verifikasi Email Anda</h1>
    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
        Terima kasih telah mendaftar. Sebelum melanjutkan, mohon periksa email Anda untuk tautan verifikasi.
        Jika belum menerima email, Anda dapat meminta pengiriman ulang.
    </p>

    @if(session('status') === 'verification-link-sent')
        <x-alert jenis="sukses" class="mt-4">Tautan verifikasi baru telah dikirim ke email Anda.</x-alert>
    @endif

    <form method="POST" action="{{ route('verifikasi-email.kirim-ulang') }}" class="mt-6">
        @csrf
        <x-tombol type="submit" varian="utama" class="w-full">Kirim Ulang Email Verifikasi</x-tombol>
    </form>

    <form method="POST" action="{{ route('keluar') }}" class="mt-3">
        @csrf
        <x-tombol type="submit" varian="hantu" class="w-full">Keluar</x-tombol>
    </form>
</x-layout-auth>
