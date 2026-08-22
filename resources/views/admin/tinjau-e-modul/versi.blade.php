<x-layout-dashboard judul-seo="Versi E-Modul" :menu="\App\Support\MenuDashboard::administrator()">
    <a href="{{ route('admin.tinjau-e-modul.show', $eModul) }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">&larr; Kembali ke {{ $eModul->judul }}</a>

    <div class="mt-2 flex items-center justify-between gap-4">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Versi {{ $versi->nomor_versi }}</h1>
        <x-badge warna="slate">Cuplikan arsip &mdash; tidak dapat diubah</x-badge>
    </div>
    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
        Diterbitkan {{ $versi->dibuat_pada?->translatedFormat('d F Y, H:i') }} WIB
        @if($versi->penerbit) oleh {{ $versi->penerbit->nama_lengkap }} @endif
    </p>

    <x-versi-e-modul-detail :versi="$versi" />
</x-layout-dashboard>
