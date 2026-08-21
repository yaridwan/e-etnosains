@props(['nama', 'judul' => null])

<div
    x-data="{ terbuka: false }"
    x-on:buka-modal.window="if ($event.detail === '{{ $nama }}') terbuka = true"
    x-on:tutup-modal.window="terbuka = false"
    @keydown.escape.window="terbuka = false"
    x-show="terbuka"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    role="dialog"
    aria-modal="true"
>
    <div x-show="terbuka" x-transition.opacity class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="terbuka = false"></div>

    <div x-show="terbuka" x-transition class="relative max-h-[85vh] w-full max-w-lg overflow-y-auto rounded-2xl bg-white p-6 shadow-xl dark:bg-slate-900">
        <div class="mb-4 flex items-center justify-between gap-4">
            <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">{{ $judul }}</h3>
            <button type="button" @click="terbuka = false" class="shrink-0 text-slate-400 dark:text-slate-500 transition hover:text-slate-600 dark:hover:text-slate-200" aria-label="Tutup">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
            </button>
        </div>

        {{ $slot }}
    </div>
</div>
