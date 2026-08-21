<x-layout-dashboard judul-seo="Pratinjau E-Modul" :menu="\App\Support\MenuDashboard::guru()">
    <a href="{{ route('guru.e-modul.edit', $eModul) }}" class="text-sm text-teal-700 hover:underline">&larr; Kembali ke form</a>

    <x-alert jenis="info" class="mt-4">Ini adalah pratinjau, tampilan mendekati halaman publik setelah dipublikasikan.</x-alert>

    <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white">
        @if($eModul->gambar_sampul)
            <img src="{{ \Illuminate\Support\Facades\Storage::url($eModul->gambar_sampul) }}" class="h-64 w-full object-cover" alt="{{ $eModul->judul }}">
        @endif
        <div class="p-6 sm:p-8">
            <div class="flex flex-wrap gap-2">
                <x-badge warna="teal">{{ $eModul->mataPelajaran->nama_mata_pelajaran }}</x-badge>
                <x-badge warna="slate">{{ $eModul->jenjangPendidikan->nama_jenjang }}</x-badge>
                @if($eModul->topikEtnosains)<x-badge warna="amber">{{ $eModul->topikEtnosains->nama_topik }}</x-badge>@endif
            </div>
            <h1 class="mt-4 text-2xl font-bold text-slate-900">{{ $eModul->judul }}</h1>
            <p class="mt-3 text-slate-600">{{ $eModul->ringkasan }}</p>

            <div class="prose-etnosains mt-6 text-sm text-slate-700">{!! nl2br(e($eModul->deskripsi)) !!}</div>

            <div class="mt-8 rounded-xl bg-teal-50 p-5">
                <h2 class="font-semibold text-teal-900">Eksplorasi Etnosains</h2>
                <dl class="mt-3 space-y-3 text-sm">
                    <div><dt class="font-medium text-slate-700">Pengetahuan Lokal</dt><dd class="text-slate-600">{{ $eModul->pengetahuan_lokal }}</dd></div>
                    <div><dt class="font-medium text-slate-700">Konsep Sains</dt><dd class="text-slate-600">{{ $eModul->konsep_sains }}</dd></div>
                    <div><dt class="font-medium text-slate-700">Konteks Wilayah</dt><dd class="text-slate-600">{{ $eModul->konteks_wilayah }}</dd></div>
                    <div><dt class="font-medium text-slate-700">Nilai/Karakter</dt><dd class="text-slate-600">{{ $eModul->nilai_karakter }}</dd></div>
                </dl>
            </div>
        </div>
    </div>
</x-layout-dashboard>
