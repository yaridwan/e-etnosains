<x-layout-publik :judul-seo="$lkpd->judul.' | E-ETNOSAINS'" :deskripsi-seo="$lkpd->deskripsi">
    <div class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        <nav class="text-sm text-slate-500 dark:text-slate-400">
            <a href="{{ route('beranda') }}" class="hover:text-teal-700 dark:hover:text-teal-400">Beranda</a> /
            <a href="{{ route('lkpd.index') }}" class="hover:text-teal-700 dark:hover:text-teal-400">LKPD</a> /
            <span class="text-slate-700 dark:text-slate-300">{{ $lkpd->judul }}</span>
        </nav>

        <h1 class="mt-4 text-3xl font-bold text-slate-900 dark:text-slate-100">{{ $lkpd->judul }}</h1>
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Oleh {{ $lkpd->pengguna->nama_lengkap }} &middot; {{ $lkpd->mataPelajaran->nama_mata_pelajaran }}</p>

        @if($lkpd->eModul)
            <a href="{{ route('e-modul.show', $lkpd->eModul) }}" class="mt-3 inline-block text-sm text-teal-700 dark:text-teal-400 hover:underline">Terkait E-Modul: {{ $lkpd->eModul->judul }} &rarr;</a>
        @endif

        <div class="mt-6 flex flex-wrap gap-3">
            @if($lkpd->izin_unduh && $lkpd->berkas_pdf)
                <x-tombol :href="route('lkpd.unduh', $lkpd)" varian="{{ $lkpd->observasi->isNotEmpty() ? 'sekunder' : 'utama' }}">Unduh PDF</x-tombol>
            @endif
        </div>

        <div class="prose-etnosains mt-8 space-y-6 text-slate-700 dark:text-slate-300">
            @if($lkpd->deskripsi)<div><h2 class="font-semibold text-slate-900 dark:text-slate-100">Deskripsi</h2><p class="mt-1">{{ $lkpd->deskripsi }}</p></div>@endif
            @if($lkpd->tujuan)<div><h2 class="font-semibold text-slate-900 dark:text-slate-100">Tujuan</h2><p class="mt-1">{{ $lkpd->tujuan }}</p></div>@endif
            @if($lkpd->petunjuk)<div><h2 class="font-semibold text-slate-900 dark:text-slate-100">Petunjuk</h2><p class="mt-1">{{ $lkpd->petunjuk }}</p></div>@endif
            @if($lkpd->aktivitas)<div><h2 class="font-semibold text-slate-900 dark:text-slate-100">Aktivitas</h2><p class="mt-1">{{ $lkpd->aktivitas }}</p></div>@endif
            @if($lkpd->pertanyaan)<div><h2 class="font-semibold text-slate-900 dark:text-slate-100">Pertanyaan</h2><p class="mt-1">{{ $lkpd->pertanyaan }}</p></div>@endif
        </div>

        @if($lkpd->observasi->isNotEmpty())
            <div class="mt-10 rounded-2xl border border-teal-200 bg-teal-50 p-6 dark:border-teal-900 dark:bg-teal-950/40">
                <h2 class="font-semibold text-teal-900 dark:text-teal-200">LKPD Interaktif</h2>
                <p class="mt-1 text-sm text-teal-800 dark:text-teal-300">LKPD ini punya versi interaktif yang bisa langsung diisi dan dikumpulkan secara daring, tanpa perlu mencetak berkas PDF.</p>

                <div class="mt-4 space-y-3">
                    @foreach($lkpd->observasi as $observasiTerkait)
                        <div class="flex flex-wrap items-center justify-between gap-3 rounded-xl bg-white dark:bg-slate-900 px-4 py-3">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $observasiTerkait->judul }}</span>

                            @auth
                                @if(auth()->user()->isSiswa())
                                    <x-tombol :href="route('siswa.observasi.show', $observasiTerkait)" class="px-3! py-1.5! text-sm">Kerjakan Sekarang</x-tombol>
                                @else
                                    <x-tombol :href="route('observasi.show', $observasiTerkait)" varian="sekunder" class="px-3! py-1.5! text-sm">Lihat Instrumen</x-tombol>
                                @endif
                            @else
                                <x-tombol :href="route('masuk')" class="px-3! py-1.5! text-sm">Masuk untuk Mengerjakan</x-tombol>
                            @endauth
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layout-publik>
