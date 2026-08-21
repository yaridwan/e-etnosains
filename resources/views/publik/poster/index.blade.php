<x-layout-publik judul-seo="Poster Edukasi | E-ETNOSAINS">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">Poster Edukasi</h1>
        <p class="mt-2 text-slate-500 dark:text-slate-400">Galeri poster pembelajaran etnosains.</p>

        @if($poster->isEmpty())
            <div class="mt-8"><x-empty-state judul="Belum ada poster yang dipublikasikan." /></div>
        @else
            <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                @foreach($poster as $item)
                    <div class="overflow-hidden rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900">
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($item->gambar) }}" class="aspect-[3/4] w-full object-cover" alt="{{ $item->judul }}" loading="lazy">
                        <p class="truncate p-3 text-sm font-medium text-slate-700 dark:text-slate-300">{{ $item->judul }}</p>
                    </div>
                @endforeach
            </div>
            <div class="mt-8">{{ $poster->links() }}</div>
        @endif
    </div>
</x-layout-publik>
