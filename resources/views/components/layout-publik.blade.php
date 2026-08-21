@props(['judulSeo' => null, 'deskripsiSeo' => null])

<x-layout-app :judul-seo="$judulSeo" :deskripsi-seo="$deskripsiSeo">
    <x-navbar-publik />

    @if(session('status'))
        <div class="mx-auto max-w-7xl px-4 pt-4 sm:px-6 lg:px-8">
            <x-alert jenis="sukses">{{ session('status') }}</x-alert>
        </div>
    @endif

    <main>
        {{ $slot }}
    </main>

    <x-footer-publik />
</x-layout-app>
