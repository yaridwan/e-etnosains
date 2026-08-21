<x-layout-publik judul-seo="Bahan Ajar | E-ETNOSAINS">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">Bahan Ajar</h1>
        <p class="mt-2 text-slate-500 dark:text-slate-400">Materi pendukung pembelajaran berbasis etnosains.</p>

        @if($bahanAjar->isEmpty())
            <div class="mt-8"><x-empty-state judul="Belum ada bahan ajar yang dipublikasikan." /></div>
        @else
            <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($bahanAjar as $item)
                    <a href="{{ route('bahan-ajar.show', $item) }}" class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 hover:border-teal-600 dark:hover:border-teal-500">
                        <x-badge warna="teal">{{ $item->mataPelajaran->nama_mata_pelajaran }}</x-badge>
                        <p class="mt-3 font-semibold text-slate-800 dark:text-slate-100">{{ $item->judul }}</p>
                        <p class="mt-1 text-xs uppercase text-slate-400 dark:text-slate-500">{{ $item->jenis_berkas }}</p>
                    </a>
                @endforeach
            </div>
            <div class="mt-8">{{ $bahanAjar->links() }}</div>
        @endif
    </div>
</x-layout-publik>
