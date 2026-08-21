@props(['kode', 'judul', 'pesan'])

<x-layout-app :judul-seo="$kode.' - '.$judul">
    <div class="flex min-h-screen flex-col items-center justify-center bg-gradient-to-b from-teal-50 via-white to-white px-4 text-center">
        <a href="{{ route('beranda') }}" class="mb-8 flex items-center gap-2 font-bold text-teal-800">
            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-teal-700 text-white">E</span>
            <span class="text-xl">{{ pengaturan('nama_singkat', 'E-ETNOSAINS') }}</span>
        </a>

        <p class="text-6xl font-bold text-teal-700">{{ $kode }}</p>
        <h1 class="mt-3 text-xl font-bold text-slate-900">{{ $judul }}</h1>
        <p class="mt-2 max-w-md text-sm text-slate-500">{{ $pesan }}</p>

        <x-tombol :href="route('beranda')" class="mt-6">Kembali ke Beranda</x-tombol>
    </div>
</x-layout-app>
