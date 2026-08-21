<x-layout-publik :judul-seo="'Baca '.$eModul->judul.' | E-ETNOSAINS'">
    @vite('resources/js/flipbook.js')

    <div class="bg-slate-900" data-flipbook-bingkai>
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3 text-white">
            <a href="{{ route('e-modul.show', $eModul) }}" class="flex items-center gap-2 text-sm hover:text-teal-300">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                Kembali
            </a>
            <p class="truncate text-sm font-medium">{{ $eModul->judul }}</p>
            <div class="flex items-center gap-3 text-sm">
                <button id="fb-zoom-keluar" class="hover:text-teal-300" aria-label="Perkecil">&minus;</button>
                <button id="fb-zoom-masuk" class="hover:text-teal-300" aria-label="Perbesar">&#43;</button>
                <button id="fb-layar-penuh" class="hover:text-teal-300" aria-label="Layar penuh">⛶</button>
            </div>
        </div>

        <div class="flex min-h-[70vh] items-center justify-center px-4 pb-6">
            <p id="fb-status" class="text-sm text-slate-300">Memuat E-Modul…</p>
            <div id="fb-container" class="mx-auto h-[75vh] max-h-[800px] w-full max-w-4xl"></div>
        </div>

        <div class="mx-auto flex max-w-6xl items-center justify-center gap-6 px-4 pb-6 text-white">
            <button id="fb-sebelumnya" class="rounded-full bg-white/10 px-4 py-2 text-sm hover:bg-white/20">&larr; Sebelumnya</button>
            <span class="text-sm">Halaman <span id="fb-nomor-halaman">1</span> / <span id="fb-total-halaman">-</span></span>
            <button id="fb-berikutnya" class="rounded-full bg-white/10 px-4 py-2 text-sm hover:bg-white/20">Berikutnya &rarr;</button>
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => window.inisialisasiFlipbook({
            elemenContainer: document.getElementById('fb-container'),
            urlPdf: @json(\Illuminate\Support\Facades\Storage::url($eModul->berkas_pdf)),
            elemenStatus: document.getElementById('fb-status'),
            elemenNomorHalaman: document.getElementById('fb-nomor-halaman'),
            elemenTotalHalaman: document.getElementById('fb-total-halaman'),
            tombolSebelumnya: document.getElementById('fb-sebelumnya'),
            tombolBerikutnya: document.getElementById('fb-berikutnya'),
            tombolZoomMasuk: document.getElementById('fb-zoom-masuk'),
            tombolZoomKeluar: document.getElementById('fb-zoom-keluar'),
            tombolLayarPenuh: document.getElementById('fb-layar-penuh'),
        }));
    </script>
</x-layout-publik>
