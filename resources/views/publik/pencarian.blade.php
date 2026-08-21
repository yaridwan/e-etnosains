<x-layout-publik judul-seo="Pencarian | E-ETNOSAINS">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Hasil Pencarian {{ $kataKunci ? 'untuk "'.$kataKunci.'"' : '' }}</h1>

        <form method="GET" class="mt-6 grid grid-cols-1 gap-3 sm:grid-cols-5">
            <input type="search" name="q" value="{{ $kataKunci }}" placeholder="Kata kunci..." class="rounded-lg border border-slate-300 dark:border-slate-700 px-3.5 py-2 text-sm sm:col-span-2">
            <select name="jenjang" class="rounded-lg border border-slate-300 dark:border-slate-700 px-3.5 py-2 text-sm">
                <option value="">Semua Jenjang</option>
                @foreach($jenjang as $item)<option value="{{ $item->id }}" @selected(request('jenjang')==$item->id)>{{ $item->nama_jenjang }}</option>@endforeach
            </select>
            <select name="mata_pelajaran" class="rounded-lg border border-slate-300 dark:border-slate-700 px-3.5 py-2 text-sm">
                <option value="">Semua Mata Pelajaran</option>
                @foreach($mataPelajaran as $item)<option value="{{ $item->id }}" @selected(request('mata_pelajaran')==$item->id)>{{ $item->nama_mata_pelajaran }}</option>@endforeach
            </select>
            <select name="urutkan" class="rounded-lg border border-slate-300 dark:border-slate-700 px-3.5 py-2 text-sm">
                <option value="terbaru" @selected(request('urutkan')!=='terpopuler')>Terbaru</option>
                <option value="terpopuler" @selected(request('urutkan')==='terpopuler')>Terpopuler</option>
            </select>
            <button type="submit" class="rounded-lg bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800 sm:col-span-5 sm:w-fit">Terapkan Filter</button>
        </form>

        @if($hasil->isEmpty())
            <div class="mt-8"><x-empty-state judul="Tidak ada hasil ditemukan." deskripsi="Coba kata kunci atau filter lain." /></div>
        @else
            <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($hasil as $item)
                    @include('publik.partials.kartu-e-modul', ['eModul' => $item])
                @endforeach
            </div>
            <div class="mt-8">{{ $hasil->links() }}</div>
        @endif
    </div>
</x-layout-publik>
