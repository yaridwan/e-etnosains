@props(['judulSeo' => null, 'lebar' => 'max-w-md'])

<x-layout-app :judul-seo="$judulSeo">
    <div class="relative flex min-h-screen flex-col items-center justify-center bg-gradient-to-b from-teal-50 via-white to-white px-4 py-12 dark:from-slate-900 dark:via-slate-950 dark:to-slate-950">
        <div class="absolute right-4 top-4 sm:right-6 sm:top-6">
            <x-tema-toggle />
        </div>

        <a href="{{ route('beranda') }}" class="mb-8 flex items-center gap-2.5">
            <x-logo-aplikasi ukuran="h-10 w-10" teks="text-base" />
            <span class="text-xl font-bold tracking-tight text-teal-800 dark:text-teal-300">
                {{ pengaturan('nama_singkat', 'E-ETNOSAINS') }}
            </span>
        </a>

        <div class="w-full {{ $lebar }}">
            @if(session('status'))
                <x-alert jenis="sukses" class="mb-4">{{ session('status') }}</x-alert>
            @endif

            <x-kartu>
                {{ $slot }}
            </x-kartu>

            <p class="mt-6 text-center text-xs text-slate-400 dark:text-slate-500">
                &copy; {{ now()->year }} {{ pengaturan('nama_aplikasi', 'E-ETNOSAINS') }}
            </p>
        </div>
    </div>
</x-layout-app>
