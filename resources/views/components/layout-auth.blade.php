@props(['judulSeo' => null])

<x-layout-app :judul-seo="$judulSeo">
    <div class="flex min-h-screen flex-col items-center justify-center bg-gradient-to-b from-teal-50 via-white to-white px-4 py-12">
        <a href="{{ route('beranda') }}" class="mb-8 flex items-center gap-2 font-bold text-teal-800">
            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-teal-700 text-white">E</span>
            <span class="text-xl">{{ pengaturan('nama_singkat', 'E-ETNOSAINS') }}</span>
        </a>

        <div class="w-full max-w-md">
            @if(session('status'))
                <x-alert jenis="sukses" class="mb-4">{{ session('status') }}</x-alert>
            @endif

            <x-kartu>
                {{ $slot }}
            </x-kartu>
        </div>
    </div>
</x-layout-app>
