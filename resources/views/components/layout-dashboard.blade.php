@props(['judulSeo' => null, 'menu' => [], 'labelPeran' => ''])

<x-layout-app :judul-seo="$judulSeo">
    <div x-data="{ sidebarTerbuka: false }" class="flex min-h-screen bg-slate-50">
        <!-- Sidebar desktop -->
        <aside class="hidden w-64 flex-col border-r border-slate-200 bg-white lg:flex">
            <a href="{{ route('beranda') }}" class="flex h-16 items-center gap-2 border-b border-slate-100 px-6 font-bold text-teal-800">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-teal-700 text-white">E</span>
                {{ pengaturan('nama_singkat', 'E-ETNOSAINS') }}
            </a>
            <nav class="flex-1 space-y-6 overflow-y-auto px-4 py-6">
                @foreach($menu as $kelompok => $item)
                    <div>
                        @if(is_string($kelompok))
                            <p class="mb-2 px-2 text-xs font-semibold uppercase tracking-wider text-slate-400">{{ $kelompok }}</p>
                        @endif
                        <div class="space-y-1">
                            @foreach($item as $tautan)
                                <a href="{{ $tautan['url'] }}"
                                   class="flex items-center gap-2.5 rounded-lg px-3 py-2 text-sm font-medium {{ $tautan['aktif'] ?? false ? 'bg-teal-50 text-teal-800' : 'text-slate-600 hover:bg-slate-50' }}">
                                    {{ $tautan['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </nav>
        </aside>

        <!-- Sidebar mobile -->
        <div x-show="sidebarTerbuka" x-cloak class="fixed inset-0 z-50 lg:hidden">
            <div class="fixed inset-0 bg-slate-900/50" @click="sidebarTerbuka = false"></div>
            <aside class="relative flex h-full w-72 flex-col bg-white">
                <div class="flex h-16 items-center justify-between border-b border-slate-100 px-6 font-bold text-teal-800">
                    {{ pengaturan('nama_singkat', 'E-ETNOSAINS') }}
                    <button @click="sidebarTerbuka = false" aria-label="Tutup menu">&times;</button>
                </div>
                <nav class="flex-1 space-y-6 overflow-y-auto px-4 py-6">
                    @foreach($menu as $kelompok => $item)
                        <div>
                            @if(is_string($kelompok))
                                <p class="mb-2 px-2 text-xs font-semibold uppercase tracking-wider text-slate-400">{{ $kelompok }}</p>
                            @endif
                            <div class="space-y-1">
                                @foreach($item as $tautan)
                                    <a href="{{ $tautan['url'] }}" class="flex items-center gap-2.5 rounded-lg px-3 py-2 text-sm font-medium {{ $tautan['aktif'] ?? false ? 'bg-teal-50 text-teal-800' : 'text-slate-600 hover:bg-slate-50' }}">
                                        {{ $tautan['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </nav>
            </aside>
        </div>

        <div class="flex flex-1 flex-col">
            <header class="flex h-16 items-center justify-between border-b border-slate-200 bg-white px-4 sm:px-6">
                <button @click="sidebarTerbuka = true" class="lg:hidden" aria-label="Buka menu">
                    <svg class="h-6 w-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                </button>

                <span class="hidden text-sm font-medium text-slate-500 lg:block">{{ $labelPeran }}</span>

                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium text-slate-700">{{ auth()->user()->nama_lengkap }}</span>
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-teal-100 text-sm font-semibold text-teal-800">
                        {{ Str::of(auth()->user()->nama_lengkap)->substr(0, 1)->upper() }}
                    </div>
                    <form method="POST" action="{{ route('keluar') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-slate-500 hover:text-rose-600">Keluar</button>
                    </form>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @if(session('status'))
                    <x-alert jenis="sukses" class="mb-6">{{ session('status') }}</x-alert>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    <x-dialog-konfirmasi />
</x-layout-app>
