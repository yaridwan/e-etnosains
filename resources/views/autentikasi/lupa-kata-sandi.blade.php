<x-layout-auth judul-seo="Lupa Kata Sandi">
    <h1 class="text-xl font-bold text-slate-900">Lupa Kata Sandi</h1>
    <p class="mt-1 text-sm text-slate-500">Masukkan email Anda, kami akan mengirimkan tautan atur ulang kata sandi.</p>

    <form method="POST" action="{{ route('lupa-kata-sandi.proses') }}" class="mt-6 space-y-4">
        @csrf
        <x-input label="Email" name="email" type="email" wajib autofocus />
        <x-tombol type="submit" varian="utama" class="w-full">Kirim Tautan Atur Ulang</x-tombol>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        <a href="{{ route('masuk') }}" class="font-medium text-teal-700 hover:underline">Kembali ke halaman masuk</a>
    </p>
</x-layout-auth>
