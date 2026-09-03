@php($tautanDashboard = auth()->check()
    ? (auth()->user()->isAdministrator()
        ? route('admin.dashboard')
        : (auth()->user()->isGuru() ? route('guru.dashboard') : route('siswa.dashboard')))
    : null)

<header
    x-data="{ mobileOpen: false, cariOpen: false }"
    class="sticky top-0 z-40 border-b border-slate-200/70 bg-white/85 backdrop-blur-md dark:border-slate-800 dark:bg-slate-950/85"
>
    <nav class="mx-auto flex h-16 max-w-7xl items-center gap-3 px-4 sm:px-6 lg:px-8">
        {{-- Merek: whitespace-nowrap mencegah nama aplikasi patah menjadi dua baris --}}
        <a href="{{ route('beranda') }}" class="flex shrink-0 items-center gap-2.5 whitespace-nowrap">
            <x-logo-aplikasi ukuran="h-9 w-9" />
            <span class="text-base font-bold tracking-tight text-teal-800 dark:text-teal-300">
                {{ pengaturan('nama_singkat', 'E-ETNOSAINS') }}
            </span>
        </a>

        {{-- Menu utama --}}
        <div class="ml-2 hidden items-center gap-1 lg:flex">
            @foreach($menuNavigasi as $menu)
                @if($menu->anak->isNotEmpty())
                    <div x-data="{ buka: false }" class="relative" @mouseleave="buka = false">
                        <button
                            type="button"
                            @click="buka = ! buka"
                            @mouseenter="buka = true"
                            @click.outside="buka = false"
                            :aria-expanded="buka"
                            class="flex items-center gap-1 whitespace-nowrap rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-teal-700 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-teal-300"
                        >
                            {{ $menu->label }}
                            <svg class="h-3.5 w-3.5 transition" :class="buka && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>

                        <div
                            x-show="buka"
                            x-cloak
                            x-transition.origin.top.left
                            class="absolute left-0 z-50 mt-1 w-56 overflow-hidden rounded-xl border border-slate-200 bg-white p-1.5 shadow-lg dark:border-slate-700 dark:bg-slate-900"
                        >
                            @foreach($menu->anak as $submenu)
                                <a
                                    href="{{ $submenu->tautan }}"
                                    class="block whitespace-nowrap rounded-lg px-3 py-2 text-sm text-slate-600 transition hover:bg-teal-50 hover:text-teal-800 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-teal-300"
                                >
                                    {{ $submenu->label }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a
                        href="{{ $menu->tautan }}"
                        class="whitespace-nowrap rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-teal-700 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-teal-300"
                    >
                        {{ $menu->label }}
                    </a>
                @endif
            @endforeach
        </div>

        {{-- Aksi kanan --}}
        <div class="ml-auto flex items-center gap-2">
            <form action="{{ route('pencarian') }}" method="GET" class="relative hidden xl:block">
                <input
                    type="search"
                    name="q"
                    placeholder="Cari e-modul..."
                    value="{{ request('q') }}"
                    class="w-52 rounded-full border border-slate-200 bg-slate-50 py-2 pl-4 pr-9 text-sm text-slate-700 transition placeholder:text-slate-400 focus:border-teal-600 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-600/30 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:placeholder:text-slate-500 dark:focus:bg-slate-900"
                >
                <button type="submit" class="absolute right-3 top-2.5 text-slate-400 dark:text-slate-500 transition hover:text-teal-700 dark:hover:text-teal-400" aria-label="Cari">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                </button>
            </form>

            {{-- Tombol cari ringkas untuk layar sedang --}}
            <a href="{{ route('pencarian') }}" class="hidden h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:border-teal-600 dark:hover:border-teal-500 hover:text-teal-700 dark:hover:text-teal-400 lg:flex xl:hidden dark:border-slate-700 dark:text-slate-300" aria-label="Cari">
                <svg class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
            </a>

            <x-tema-toggle />

            <div class="hidden items-center gap-2 lg:flex">
                @auth
                    <x-tombol :href="$tautanDashboard" varian="sekunder">Dashboard</x-tombol>
                @else
                    <x-tombol :href="route('masuk')" varian="hantu">Masuk</x-tombol>
                    <x-tombol :href="route('daftar')" varian="utama">Daftar</x-tombol>
                @endauth
            </div>

            <button
                @click="mobileOpen = ! mobileOpen"
                class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 lg:hidden dark:border-slate-700 dark:text-slate-300"
                :aria-expanded="mobileOpen"
                aria-label="Buka menu"
            >
                <svg x-show="! mobileOpen" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <svg x-show="mobileOpen" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </nav>

    {{-- Menu mobile --}}
    <div
        x-show="mobileOpen"
        x-cloak
        x-transition.origin.top
        class="border-t border-slate-200 bg-white px-4 py-4 lg:hidden dark:border-slate-800 dark:bg-slate-950"
    >
        <form action="{{ route('pencarian') }}" method="GET" class="relative mb-4">
            <input
                type="search"
                name="q"
                placeholder="Cari e-modul..."
                value="{{ request('q') }}"
                class="w-full rounded-full border border-slate-200 bg-slate-50 py-2.5 pl-4 pr-10 text-sm text-slate-700 focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-600/30 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200"
            >
            <button type="submit" class="absolute right-3.5 top-3 text-slate-400 dark:text-slate-500" aria-label="Cari">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
            </button>
        </form>

        <div class="flex flex-col">
            @foreach($menuNavigasi as $menu)
                <a href="{{ $menu->tautan }}" class="rounded-lg px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:text-slate-200 dark:hover:bg-slate-800">
                    {{ $menu->label }}
                </a>

                @if($menu->anak->isNotEmpty())
                    <div class="mb-1 ml-3 border-l border-slate-200 pl-3 dark:border-slate-700">
                        @foreach($menu->anak as $submenu)
                            <a href="{{ $submenu->tautan }}" class="block rounded-lg px-3 py-2 text-sm text-slate-500 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-800">
                                {{ $submenu->label }}
                            </a>
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>

        <div class="mt-3 flex gap-2 border-t border-slate-200 pt-4 dark:border-slate-800">
            @auth
                <x-tombol :href="$tautanDashboard" varian="sekunder" class="flex-1">Dashboard</x-tombol>
            @else
                <x-tombol :href="route('masuk')" varian="putih" class="flex-1">Masuk</x-tombol>
                <x-tombol :href="route('daftar')" varian="utama" class="flex-1">Daftar</x-tombol>
            @endauth
        </div>
    </div>
</header>
