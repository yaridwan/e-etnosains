<x-layout-auth judul-seo="Atur Ulang Kata Sandi">
    <h1 class="text-xl font-bold text-slate-900">Atur Ulang Kata Sandi</h1>

    <form method="POST" action="{{ route('reset-kata-sandi.proses') }}" class="mt-6 space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <x-input label="Email" name="email" type="email" value="{{ $email }}" wajib autofocus />
        <x-input label="Kata Sandi Baru" name="kata_sandi" type="password" wajib />
        <x-input label="Konfirmasi Kata Sandi Baru" name="kata_sandi_confirmation" type="password" wajib />

        <x-tombol type="submit" varian="utama" class="w-full">Simpan Kata Sandi Baru</x-tombol>
    </form>
</x-layout-auth>
