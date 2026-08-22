@props(['rute', 'parameter' => []])

{{--
    Tombol unduh laporan dengan pilihan format XLSX atau CSV. Filter yang
    sedang aktif di halaman (query string) ikut disertakan ke tautan unduhan
    supaya laporan yang diunduh sesuai dengan yang sedang dilihat.
--}}
<div x-data="{ buka: false }" class="relative inline-block">
    <button
        type="button"
        @click="buka = ! buka"
        @click.outside="buka = false"
        :aria-expanded="buka"
        class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:hover:bg-slate-800"
    >
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
        Unduh Laporan
    </button>

    <div x-show="buka" x-cloak x-transition.origin.top.right class="absolute right-0 z-20 mt-1 w-40 overflow-hidden rounded-xl border border-slate-200 bg-white p-1.5 shadow-lg dark:border-slate-700 dark:bg-slate-900">
        <a href="{{ route($rute, array_merge($parameter, request()->query(), ['format' => 'xlsx'])) }}" class="block rounded-lg px-3 py-2 text-sm text-slate-600 transition hover:bg-teal-50 hover:text-teal-800 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-teal-300">Excel (.xlsx)</a>
        <a href="{{ route($rute, array_merge($parameter, request()->query(), ['format' => 'csv'])) }}" class="block rounded-lg px-3 py-2 text-sm text-slate-600 transition hover:bg-teal-50 hover:text-teal-800 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-teal-300">CSV (.csv)</a>
    </div>
</div>
