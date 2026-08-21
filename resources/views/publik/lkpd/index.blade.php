<x-layout-publik judul-seo="LKPD | E-ETNOSAINS">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-slate-900">Lembar Kerja Peserta Didik (LKPD)</h1>
        <p class="mt-2 text-slate-500">Kumpulan LKPD berbasis aktivitas etnosains.</p>

        @if($lkpd->isEmpty())
            <div class="mt-8"><x-empty-state judul="Belum ada LKPD yang dipublikasikan." /></div>
        @else
            <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($lkpd as $item)
                    <a href="{{ route('lkpd.show', $item) }}" class="rounded-2xl border border-slate-200 bg-white p-5 hover:border-teal-600">
                        <x-badge warna="teal">{{ $item->mataPelajaran->nama_mata_pelajaran }}</x-badge>
                        <p class="mt-3 font-semibold text-slate-800">{{ $item->judul }}</p>
                        <p class="mt-1 text-xs text-slate-400">{{ $item->pengguna->nama_lengkap }}</p>
                    </a>
                @endforeach
            </div>
            <div class="mt-8">{{ $lkpd->links() }}</div>
        @endif
    </div>
</x-layout-publik>
