<x-layout-dashboard judul-seo="Pratinjau E-Modul" :menu="\App\Support\MenuDashboard::guru()">
    <a href="{{ route('guru.e-modul.edit', $eModul) }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">&larr; Kembali ke form</a>

    <x-alert jenis="info" class="mt-4">Ini adalah pratinjau, tampilan mendekati halaman publik setelah dipublikasikan.</x-alert>

    <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900">
        @if($eModul->gambar_sampul)
            <img src="{{ \Illuminate\Support\Facades\Storage::url($eModul->gambar_sampul) }}" class="h-64 w-full object-cover" alt="{{ $eModul->judul }}">
        @endif
        <div class="p-6 sm:p-8">
            <div class="flex flex-wrap gap-2">
                <x-badge warna="teal">{{ $eModul->mataPelajaran->nama_mata_pelajaran }}</x-badge>
                <x-badge warna="slate">{{ $eModul->jenjangPendidikan->nama_jenjang }}</x-badge>
                @if($eModul->topikEtnosains)<x-badge warna="amber">{{ $eModul->topikEtnosains->nama_topik }}</x-badge>@endif
            </div>
            <h1 class="mt-4 text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $eModul->judul }}</h1>
            <p class="mt-3 text-slate-600 dark:text-slate-400">{{ $eModul->ringkasan }}</p>

            <div class="prose-etnosains mt-6 text-sm text-slate-700 dark:text-slate-300">{!! nl2br(e($eModul->deskripsi)) !!}</div>

            <div class="mt-8 rounded-xl bg-teal-50 dark:bg-teal-950 p-5">
                <h2 class="font-semibold text-teal-900 dark:text-teal-200">Eksplorasi Etnosains</h2>
                <dl class="mt-3 space-y-3 text-sm">
                    <div><dt class="font-medium text-slate-700 dark:text-slate-300">Pengetahuan Lokal</dt><dd class="text-slate-600 dark:text-slate-400">{{ $eModul->pengetahuan_lokal }}</dd></div>
                    <div><dt class="font-medium text-slate-700 dark:text-slate-300">Konsep Sains</dt><dd class="text-slate-600 dark:text-slate-400">{{ $eModul->konsep_sains }}</dd></div>
                    <div><dt class="font-medium text-slate-700 dark:text-slate-300">Konteks Wilayah</dt><dd class="text-slate-600 dark:text-slate-400">{{ $eModul->konteks_wilayah }}</dd></div>
                    <div><dt class="font-medium text-slate-700 dark:text-slate-300">Nilai/Karakter</dt><dd class="text-slate-600 dark:text-slate-400">{{ $eModul->nilai_karakter }}</dd></div>
                </dl>
            </div>
        </div>
    </div>
</x-layout-dashboard>
