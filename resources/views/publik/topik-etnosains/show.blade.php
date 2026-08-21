<x-layout-publik :judul-seo="$topik->nama_topik.' | E-ETNOSAINS'" :deskripsi-seo="$topik->deskripsi">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <nav class="text-sm text-slate-500">
            <a href="{{ route('beranda') }}" class="hover:text-teal-700">Beranda</a> /
            <a href="{{ route('topik-etnosains.index') }}" class="hover:text-teal-700">Topik Etnosains</a> /
            <span class="text-slate-700">{{ $topik->nama_topik }}</span>
        </nav>

        <h1 class="mt-4 text-3xl font-bold text-slate-900">{{ $topik->nama_topik }}</h1>
        <p class="mt-2 max-w-2xl text-slate-600">{{ $topik->deskripsi }}</p>

        @if($eModul->isEmpty())
            <div class="mt-8"><x-empty-state judul="Belum ada E-Modul untuk topik ini." /></div>
        @else
            <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($eModul as $item)
                    @include('publik.partials.kartu-e-modul', ['eModul' => $item])
                @endforeach
            </div>
            <div class="mt-8">{{ $eModul->links() }}</div>
        @endif
    </div>
</x-layout-publik>
