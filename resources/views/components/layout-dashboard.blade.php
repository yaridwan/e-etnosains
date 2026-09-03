@props(['judulSeo' => null, 'menu' => [], 'labelPeran' => ''])

@php($belumDibaca = app(\App\Services\NotifikasiService::class)->jumlahBelumDibaca(auth()->user()))

<x-layout-app :judul-seo="$judulSeo">
    <div x-data="{ sidebarTerbuka: false }" class="flex min-h-screen bg-slate-50 dark:bg-slate-950">
        {{-- Sidebar desktop --}}
        <aside class="hidden w-64 shrink-0 flex-col border-r border-slate-200 bg-white lg:flex dark:border-slate-800 dark:bg-slate-900">
            <a href="{{ route('beranda') }}" class="flex h-16 items-center gap-2.5 whitespace-nowrap border-b border-slate-100 px-6 dark:border-slate-800">
                <x-logo-aplikasi ukuran="h-8 w-8" bulat="rounded-lg" />
                <span class="font-bold tracking-tight text-teal-800 dark:text-teal-300">{{ pengaturan('nama_singkat', 'E-ETNOSAINS') }}</span>
            </a>

            <nav class="flex-1 overflow-y-auto px-4 py-6">
                @foreach($menu as $kelompok => $item)
                    <div @class(['mt-6 border-t border-slate-100 pt-5 dark:border-slate-800' => ! $loop->first])>
                        @if(is_string($kelompok))
                            <p class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">{{ $kelompok }}</p>
                        @endif
                        <div class="space-y-0.5">
                            @foreach($item as $tautan)
                                <a href="{{ $tautan['url'] }}"
                                   @class([
                                       'group flex items-center gap-2.5 rounded-md border-l-2 py-2 pl-3 pr-3 text-sm font-medium transition',
                                       'border-teal-600 bg-teal-50 text-teal-800 dark:border-teal-400 dark:bg-teal-950 dark:text-teal-300' => $tautan['aktif'] ?? false,
                                       'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-100' => ! ($tautan['aktif'] ?? false),
                                   ])>
                                    <x-ikon :nama="$tautan['ikon'] ?? 'grid'"
                                        @class([
                                            'h-[18px] w-[18px] shrink-0 transition',
                                            'text-teal-700 dark:text-teal-300' => $tautan['aktif'] ?? false,
                                            'text-slate-400 group-hover:text-slate-600 dark:text-slate-500 dark:group-hover:text-slate-300' => ! ($tautan['aktif'] ?? false),
                                        ]) />
                                    <span class="truncate">{{ $tautan['label'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </nav>
        </aside>

        {{-- Sidebar mobile --}}
        <div x-show="sidebarTerbuka" x-cloak class="fixed inset-0 z-50 lg:hidden">
            <div x-show="sidebarTerbuka" x-transition.opacity class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="sidebarTerbuka = false"></div>

            <aside x-show="sidebarTerbuka" x-transition.origin.left class="relative flex h-full w-72 flex-col bg-white dark:bg-slate-900">
                <div class="flex h-16 items-center justify-between border-b border-slate-100 px-6 dark:border-slate-800">
                    <div class="flex items-center gap-2.5">
                        <x-logo-aplikasi ukuran="h-8 w-8" bulat="rounded-lg" />
                        <span class="font-bold tracking-tight text-teal-800 dark:text-teal-300">{{ pengaturan('nama_singkat', 'E-ETNOSAINS') }}</span>
                    </div>
                    <button @click="sidebarTerbuka = false" class="text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-200" aria-label="Tutup menu">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <nav class="flex-1 overflow-y-auto px-4 py-6">
                    @foreach($menu as $kelompok => $item)
                        <div @class(['mt-6 border-t border-slate-100 pt-5 dark:border-slate-800' => ! $loop->first])>
                            @if(is_string($kelompok))
                                <p class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">{{ $kelompok }}</p>
                            @endif
                            <div class="space-y-0.5">
                                @foreach($item as $tautan)
                                    <a href="{{ $tautan['url'] }}"
                                       @class([
                                           'group flex items-center gap-2.5 rounded-md border-l-2 py-2 pl-3 pr-3 text-sm font-medium transition',
                                           'border-teal-600 bg-teal-50 text-teal-800 dark:border-teal-400 dark:bg-teal-950 dark:text-teal-300' => $tautan['aktif'] ?? false,
                                           'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-100' => ! ($tautan['aktif'] ?? false),
                                       ])>
                                        <x-ikon :nama="$tautan['ikon'] ?? 'grid'"
                                            @class([
                                                'h-[18px] w-[18px] shrink-0 transition',
                                                'text-teal-700 dark:text-teal-300' => $tautan['aktif'] ?? false,
                                                'text-slate-400 group-hover:text-slate-600 dark:text-slate-500 dark:group-hover:text-slate-300' => ! ($tautan['aktif'] ?? false),
                                            ]) />
                                        <span class="truncate">{{ $tautan['label'] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </nav>
            </aside>
        </div>

        <div class="flex min-w-0 flex-1 flex-col">
            <header class="sticky top-0 z-30 flex h-16 items-center gap-3 border-b border-slate-200 bg-white/90 px-4 backdrop-blur-md sm:px-6 dark:border-slate-800 dark:bg-slate-900/90">
                <button @click="sidebarTerbuka = true" class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 lg:hidden dark:border-slate-700 dark:text-slate-300" aria-label="Buka menu">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                </button>

                <span class="hidden truncate text-sm font-medium text-slate-500 lg:block dark:text-slate-400">{{ $labelPeran }}</span>

                <div class="ml-auto flex items-center gap-2 sm:gap-3">
                    <x-tema-toggle />

                    <a href="{{ route('notifikasi.index') }}"
                       class="relative flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:border-teal-600 hover:text-teal-700 dark:border-slate-700 dark:text-slate-300 dark:hover:border-teal-500 dark:hover:text-teal-400"
                       aria-label="Notifikasi{{ $belumDibaca > 0 ? " ($belumDibaca belum dibaca)" : '' }}">
                        <svg class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                        </svg>
                        @if($belumDibaca > 0)
                            <span class="absolute -right-1 -top-1 flex h-4 min-w-4 items-center justify-center rounded-full bg-rose-600 px-1 text-[10px] font-bold text-white">
                                {{ $belumDibaca > 9 ? '9+' : $belumDibaca }}
                            </span>
                        @endif
                    </a>

                    {{-- Menu pengguna --}}
                    <div x-data="{ buka: false }" class="relative">
                        <button
                            type="button"
                            @click="buka = ! buka"
                            @click.outside="buka = false"
                            :aria-expanded="buka"
                            class="flex items-center gap-2 rounded-lg py-1 pl-1 pr-2 transition hover:bg-slate-100 dark:hover:bg-slate-800"
                        >
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-teal-100 text-sm font-semibold text-teal-800 dark:bg-teal-900 dark:text-teal-200">
                                {{ Str::of(auth()->user()->nama_lengkap)->substr(0, 1)->upper() }}
                            </span>
                            <span class="hidden max-w-[10rem] truncate text-sm font-medium text-slate-700 sm:block dark:text-slate-200">
                                {{ auth()->user()->nama_lengkap }}
                            </span>
                            <svg class="hidden h-3.5 w-3.5 text-slate-400 dark:text-slate-500 transition sm:block" :class="buka && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>

                        <div
                            x-show="buka"
                            x-cloak
                            x-transition.origin.top.right
                            class="absolute right-0 z-50 mt-2 w-56 overflow-hidden rounded-xl border border-slate-200 bg-white p-1.5 shadow-lg dark:border-slate-700 dark:bg-slate-900"
                        >
                            <div class="border-b border-slate-100 px-3 py-2 dark:border-slate-800">
                                <p class="truncate text-sm font-semibold text-slate-800 dark:text-slate-100">{{ auth()->user()->nama_lengkap }}</p>
                                <p class="truncate text-xs text-slate-400 dark:text-slate-500">{{ auth()->user()->email }}</p>
                            </div>

                            <a href="{{ route('beranda') }}" class="mt-1 flex items-center gap-2.5 rounded-lg px-3 py-2 text-sm text-slate-600 transition hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800">
                                <x-ikon nama="cari" class="h-[18px] w-[18px] shrink-0 text-slate-400 dark:text-slate-500" />
                                Lihat Situs Publik
                            </a>

                            <form method="POST" action="{{ route('keluar') }}">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-left text-sm font-medium text-rose-600 transition hover:bg-rose-50 dark:text-rose-400 dark:hover:bg-rose-950">
                                    <svg class="h-[18px] w-[18px] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M15.5 17.5 20 12.75 15.5 8" /><path d="M20 12.75H9" /><path d="M13 5.5H6.5A1.5 1.5 0 0 0 5 7v10a1.5 1.5 0 0 0 1.5 1.5H13" /></svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @if(session('status'))
                    <x-alert jenis="sukses" class="mb-6">{{ session('status') }}</x-alert>
                @endif
                @if(session('galat'))
                    <x-alert jenis="bahaya" class="mb-6">{{ session('galat') }}</x-alert>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    <x-dialog-konfirmasi />
</x-layout-app>
