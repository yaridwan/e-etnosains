<x-layout-publik :judul-seo="$evaluasi->judul.' | E-ETNOSAINS'" :deskripsi-seo="$evaluasi->deskripsi">
    <div class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        <nav class="text-sm text-slate-500 dark:text-slate-400">
            <a href="{{ route('beranda') }}" class="hover:text-teal-700 dark:hover:text-teal-400">Beranda</a> /
            <a href="{{ route('evaluasi.index') }}" class="hover:text-teal-700 dark:hover:text-teal-400">Evaluasi</a> /
            <span class="text-slate-700 dark:text-slate-300">{{ $evaluasi->judul }}</span>
        </nav>

        <div class="mt-4 flex flex-wrap gap-2">
            <x-badge warna="teal">{{ $evaluasi->mataPelajaran->nama_mata_pelajaran }}</x-badge>
            <x-badge warna="slate">{{ $evaluasi->jenjangPendidikan->nama_jenjang }}</x-badge>
            <x-badge warna="violet">{{ $evaluasi->labelJenisEvaluasi() }}</x-badge>
        </div>

        <h1 class="mt-3 text-3xl font-bold text-slate-900 dark:text-slate-100">{{ $evaluasi->judul }}</h1>
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Oleh {{ $evaluasi->pengguna->nama_lengkap }} &middot; {{ $evaluasi->mataPelajaran->nama_mata_pelajaran }}</p>

        @if($evaluasi->eModul)
            <a href="{{ route('e-modul.show', $evaluasi->eModul) }}" class="mt-3 inline-block text-sm text-teal-700 dark:text-teal-400 hover:underline">Terkait E-Modul: {{ $evaluasi->eModul->judul }} &rarr;</a>
        @endif

        <dl class="mt-6 grid grid-cols-1 gap-4 rounded-2xl bg-slate-50 dark:bg-slate-900 p-5 text-sm sm:grid-cols-2">
            @if($evaluasi->kkm)
                <div><dt class="text-slate-400 dark:text-slate-500">KKM</dt><dd class="font-medium text-slate-700 dark:text-slate-300">{{ $evaluasi->kkm }}</dd></div>
            @endif
            @if($evaluasi->durasi_menit)
                <div><dt class="text-slate-400 dark:text-slate-500">Durasi Pengerjaan</dt><dd class="font-medium text-slate-700 dark:text-slate-300">{{ $evaluasi->durasi_menit }} menit</dd></div>
            @endif
        </dl>

        <div class="mt-6 flex flex-wrap gap-3">
            @if($evaluasi->izin_unduh && $evaluasi->berkas_pdf)
                <x-tombol :href="route('evaluasi.unduh', $evaluasi)">Unduh Berkas Soal</x-tombol>
            @endif
        </div>

        <div class="prose-etnosains mt-8 space-y-6 text-slate-700 dark:text-slate-300">
            @if($evaluasi->deskripsi)<div><h2 class="font-semibold text-slate-900 dark:text-slate-100">Deskripsi</h2><p class="mt-1">{{ $evaluasi->deskripsi }}</p></div>@endif
            @if($evaluasi->petunjuk)<div><h2 class="font-semibold text-slate-900 dark:text-slate-100">Petunjuk Pengerjaan</h2><p class="mt-1">{{ $evaluasi->petunjuk }}</p></div>@endif
        </div>
    </div>
</x-layout-publik>
