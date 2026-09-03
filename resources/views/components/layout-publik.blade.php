@props(['judulSeo' => null, 'deskripsiSeo' => null])

<x-layout-app :judul-seo="$judulSeo" :deskripsi-seo="$deskripsiSeo">
    <div class="flex min-h-screen flex-col">
        <x-navbar-publik />

        @if(session('status'))
            <div class="mx-auto max-w-7xl px-4 pt-4 sm:px-6 lg:px-8">
                <x-alert jenis="sukses">{{ session('status') }}</x-alert>
            </div>
        @endif

        <main class="flex-1">
            {{ $slot }}
        </main>

        <x-footer-publik />
    </div>
</x-layout-app>
