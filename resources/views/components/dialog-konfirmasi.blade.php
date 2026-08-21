<div
    x-data="{ terbuka: false, formAktif: null, pesan: '' }"
    x-on:minta-konfirmasi.window="terbuka = true; formAktif = $event.detail.form; pesan = $event.detail.pesan"
    @keydown.escape.window="terbuka = false"
    x-show="terbuka"
    x-cloak
    class="fixed inset-0 z-[60] flex items-center justify-center p-4"
    role="alertdialog"
    aria-modal="true"
>
    <div x-show="terbuka" x-transition.opacity class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="terbuka = false"></div>

    <div x-show="terbuka" x-transition class="relative w-full max-w-sm rounded-2xl bg-white p-6 text-center shadow-xl dark:bg-slate-900">
        <svg class="mx-auto mb-3 h-10 w-10 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
        </svg>
        <p class="text-sm text-slate-600 dark:text-slate-300" x-text="pesan"></p>
        <div class="mt-5 flex justify-center gap-3">
            <button type="button" @click="terbuka = false" class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">Batal</button>
            <button type="button" @click="formAktif.submit(); terbuka = false" class="rounded-lg bg-rose-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-rose-700">Ya, Hapus</button>
        </div>
    </div>
</div>
