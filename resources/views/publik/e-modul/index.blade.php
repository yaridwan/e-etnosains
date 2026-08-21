<x-layout-publik judul-seo="E-Modul | E-ETNOSAINS">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-slate-900">E-Modul Etnosains</h1>
        <p class="mt-2 text-slate-500">Kumpulan e-modul pembelajaran berbasis kearifan lokal Indonesia.</p>

        @if($eModul->isEmpty())
            <div class="mt-8"><x-empty-state judul="Belum ada E-Modul yang dipublikasikan." /></div>
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
