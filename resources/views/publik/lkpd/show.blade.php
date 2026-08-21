<x-layout-publik :judul-seo="$lkpd->judul.' | E-ETNOSAINS'" :deskripsi-seo="$lkpd->deskripsi">
    <div class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        <nav class="text-sm text-slate-500">
            <a href="{{ route('beranda') }}" class="hover:text-teal-700">Beranda</a> /
            <a href="{{ route('lkpd.index') }}" class="hover:text-teal-700">LKPD</a> /
            <span class="text-slate-700">{{ $lkpd->judul }}</span>
        </nav>

        <h1 class="mt-4 text-3xl font-bold text-slate-900">{{ $lkpd->judul }}</h1>
        <p class="mt-2 text-sm text-slate-500">Oleh {{ $lkpd->pengguna->nama_lengkap }} &middot; {{ $lkpd->mataPelajaran->nama_mata_pelajaran }}</p>

        @if($lkpd->eModul)
            <a href="{{ route('e-modul.show', $lkpd->eModul) }}" class="mt-3 inline-block text-sm text-teal-700 hover:underline">Terkait E-Modul: {{ $lkpd->eModul->judul }} &rarr;</a>
        @endif

        <div class="mt-6 flex gap-3">
            @if($lkpd->izin_unduh && $lkpd->berkas_pdf)
                <x-tombol :href="route('lkpd.unduh', $lkpd)">Unduh PDF</x-tombol>
            @endif
        </div>

        <div class="prose-etnosains mt-8 space-y-6 text-slate-700">
            @if($lkpd->deskripsi)<div><h2 class="font-semibold text-slate-900">Deskripsi</h2><p class="mt-1">{{ $lkpd->deskripsi }}</p></div>@endif
            @if($lkpd->tujuan)<div><h2 class="font-semibold text-slate-900">Tujuan</h2><p class="mt-1">{{ $lkpd->tujuan }}</p></div>@endif
            @if($lkpd->petunjuk)<div><h2 class="font-semibold text-slate-900">Petunjuk</h2><p class="mt-1">{{ $lkpd->petunjuk }}</p></div>@endif
            @if($lkpd->aktivitas)<div><h2 class="font-semibold text-slate-900">Aktivitas</h2><p class="mt-1">{{ $lkpd->aktivitas }}</p></div>@endif
            @if($lkpd->pertanyaan)<div><h2 class="font-semibold text-slate-900">Pertanyaan</h2><p class="mt-1">{{ $lkpd->pertanyaan }}</p></div>@endif
        </div>
    </div>
</x-layout-publik>
