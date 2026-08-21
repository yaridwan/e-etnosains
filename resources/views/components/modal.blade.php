@props(['nama', 'judul' => null])

<div
    x-data="{ terbuka: false }"
    x-on:buka-modal.window="if ($event.detail === '{{ $nama }}') terbuka = true"
    x-on:tutup-modal.window="terbuka = false"
    x-show="terbuka"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
>
    <div x-show="terbuka" x-transition.opacity class="fixed inset-0 bg-slate-900/50" @click="terbuka = false"></div>

    <div x-show="terbuka" x-transition class="relative w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-900">{{ $judul }}</h3>
            <button type="button" @click="terbuka = false" class="text-slate-400 hover:text-slate-600" aria-label="Tutup">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
            </button>
        </div>

        {{ $slot }}
    </div>
</div>
