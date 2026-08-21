@php($sampul = $eModul->gambar_sampul ? \Illuminate\Support\Facades\Storage::url($eModul->gambar_sampul) : null)

<a href="{{ route('e-modul.show', $eModul) }}" class="group block overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 transition hover:-translate-y-0.5 hover:shadow-md">
    <div class="aspect-[4/3] w-full overflow-hidden bg-slate-100 dark:bg-slate-800">
        @if($sampul)
            <img src="{{ $sampul }}" alt="{{ $eModul->judul }}" class="h-full w-full object-cover transition group-hover:scale-105" loading="lazy">
        @else
            <div class="flex h-full w-full items-center justify-center text-slate-300 dark:text-slate-600">
                <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" /></svg>
            </div>
        @endif
    </div>
    <div class="p-4">
        <div class="flex flex-wrap gap-1.5">
            <x-badge warna="teal">{{ $eModul->mataPelajaran->nama_mata_pelajaran }}</x-badge>
            @if($eModul->topikEtnosains)<x-badge warna="amber">{{ $eModul->topikEtnosains->nama_topik }}</x-badge>@endif
        </div>
        <p class="mt-2 line-clamp-2 font-semibold text-slate-800 dark:text-slate-100 group-hover:text-teal-700">{{ $eModul->judul }}</p>
        <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">{{ $eModul->pengguna->nama_lengkap }}</p>
        <div class="mt-3 flex items-center gap-3 text-xs text-slate-400 dark:text-slate-500">
            <span>{{ $eModul->jumlah_dilihat }} dilihat</span>
            <span>&middot;</span>
            <span>{{ $eModul->jenjangPendidikan->nama_jenjang }}</span>
        </div>
    </div>
</a>
