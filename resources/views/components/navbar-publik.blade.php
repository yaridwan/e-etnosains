<header x-data="{ mobileOpen: false }" class="sticky top-0 z-40 border-b border-slate-100 bg-white/90 backdrop-blur">
    <nav class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        <a href="{{ route('beranda') }}" class="flex items-center gap-2 font-bold text-teal-800">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-teal-700 text-white">E</span>
            <span class="text-lg">{{ pengaturan('nama_singkat', 'E-ETNOSAINS') }}</span>
        </a>

        <div class="hidden items-center gap-6 lg:flex">
            @foreach($menuNavigasi as $menu)
                <a href="{{ $menu->tautan }}" class="text-sm font-medium text-slate-600 hover:text-teal-700">{{ $menu->label }}</a>
            @endforeach
        </div>

        <div class="hidden items-center gap-3 lg:flex">
            <form action="{{ route('pencarian') }}" method="GET" class="relative">
                <input type="search" name="q" placeholder="Cari e-modul..." value="{{ request('q') }}"
                    class="w-56 rounded-full border border-slate-200 bg-slate-50 py-2 pl-4 pr-9 text-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-600">
                <button type="submit" class="absolute right-3 top-2.5 text-slate-400" aria-label="Cari">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                </button>
            </form>

            @auth
                <x-tombol :href="auth()->user()->isAdministrator() ? route('admin.dashboard') : (auth()->user()->isGuru() ? route('guru.dashboard') : route('siswa.dashboard'))" varian="sekunder">
                    Dashboard
                </x-tombol>
            @else
                <x-tombol :href="route('masuk')" varian="hantu">Masuk</x-tombol>
                <x-tombol :href="route('daftar')" varian="utama">Daftar</x-tombol>
            @endauth
        </div>

        <button @click="mobileOpen = !mobileOpen" class="lg:hidden" aria-label="Buka menu">
            <svg class="h-6 w-6 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
    </nav>

    <div x-show="mobileOpen" x-cloak @click.outside="mobileOpen = false" class="border-t border-slate-100 bg-white px-4 py-4 lg:hidden">
        <div class="flex flex-col gap-3">
            @foreach($menuNavigasi as $menu)
                <a href="{{ $menu->tautan }}" class="text-sm font-medium text-slate-600">{{ $menu->label }}</a>
            @endforeach
            <div class="mt-2 flex gap-3 border-t border-slate-100 pt-3">
                @auth
                    <x-tombol :href="auth()->user()->isAdministrator() ? route('admin.dashboard') : (auth()->user()->isGuru() ? route('guru.dashboard') : route('siswa.dashboard'))" varian="sekunder" class="flex-1">
                        Dashboard
                    </x-tombol>
                @else
                    <x-tombol :href="route('masuk')" varian="hantu" class="flex-1">Masuk</x-tombol>
                    <x-tombol :href="route('daftar')" varian="utama" class="flex-1">Daftar</x-tombol>
                @endauth
            </div>
        </div>
    </div>
</header>
