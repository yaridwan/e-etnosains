<x-layout-publik judul-seo="Topik Etnosains | E-ETNOSAINS">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">Topik Etnosains</h1>
        <p class="mt-2 text-slate-500 dark:text-slate-400">Jelajahi pembelajaran berdasarkan tema kearifan lokal.</p>

        <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
            @foreach($topik as $item)
                <a href="{{ route('topik-etnosains.show', $item) }}" class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 text-center hover:border-teal-600 dark:hover:border-teal-500">
                    <p class="font-semibold text-slate-800 dark:text-slate-100">{{ $item->nama_topik }}</p>
                    <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">{{ $item->e_modul_count }} E-Modul</p>
                </a>
            @endforeach
        </div>
    </div>
</x-layout-publik>
