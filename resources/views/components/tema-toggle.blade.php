@props(['ringkas' => false])

<div
    x-data="{ terbuka: false }"
    @keydown.escape.window="terbuka = false"
    class="relative"
>
    <button
        type="button"
        @click="terbuka = ! terbuka"
        @click.outside="terbuka = false"
        :aria-expanded="terbuka"
        aria-haspopup="true"
        aria-label="Ubah tema tampilan"
        {{ $attributes->merge(['class' => 'flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:border-teal-600 hover:text-teal-700 dark:border-slate-700 dark:text-slate-300 dark:hover:border-teal-500 dark:hover:text-teal-400']) }}
    >
        {{-- Ikon matahari saat mode terang --}}
        <svg x-show="! $store.tema.gelap" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
        </svg>

        {{-- Ikon bulan saat mode gelap --}}
        <svg x-show="$store.tema.gelap" x-cloak class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
        </svg>
    </button>

    <div
        x-show="terbuka"
        x-cloak
        x-transition.origin.top.right
        class="absolute right-0 z-50 mt-2 w-44 overflow-hidden rounded-xl border border-slate-200 bg-white p-1 shadow-lg dark:border-slate-700 dark:bg-slate-900"
        role="menu"
    >
        @foreach([
            ['nilai' => 'terang', 'label' => 'Terang'],
            ['nilai' => 'gelap', 'label' => 'Gelap'],
            ['nilai' => 'sistem', 'label' => 'Ikuti Sistem'],
        ] as $opsi)
            <button
                type="button"
                role="menuitem"
                @click="$store.tema.pilih('{{ $opsi['nilai'] }}'); terbuka = false"
                class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-left text-sm text-slate-600 transition hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800"
                :class="$store.tema.pilihan === '{{ $opsi['nilai'] }}' && 'bg-teal-50 text-teal-800 dark:bg-teal-950 dark:text-teal-300'"
            >
                {{ $opsi['label'] }}
                <svg x-show="$store.tema.pilihan === '{{ $opsi['nilai'] }}'" x-cloak class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
            </button>
        @endforeach
    </div>
</div>
