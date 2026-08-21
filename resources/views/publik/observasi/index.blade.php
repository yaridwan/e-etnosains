<x-layout-publik judul-seo="Aktivitas Observasi | E-ETNOSAINS">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-slate-900">Aktivitas Observasi</h1>
        <p class="mt-2 text-slate-500">Aktivitas pengamatan lapangan berbasis kearifan lokal.</p>

        @if($observasi->isEmpty())
            <div class="mt-8"><x-empty-state judul="Belum ada aktivitas observasi yang dipublikasikan." /></div>
        @else
            <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($observasi as $item)
                    <a href="{{ route('observasi.show', $item) }}" class="rounded-2xl border border-slate-200 bg-white p-5 hover:border-teal-600">
                        <p class="font-semibold text-slate-800">{{ $item->judul }}</p>
                        <p class="mt-1 text-xs text-slate-400">{{ $item->pengguna->nama_lengkap }} &middot; {{ $item->lokasi_observasi }}</p>
                    </a>
                @endforeach
            </div>
            <div class="mt-8">{{ $observasi->links() }}</div>
        @endif
    </div>
</x-layout-publik>
