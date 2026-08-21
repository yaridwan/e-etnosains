<x-layout-publik :judul-seo="$guru->nama_lengkap.' | E-ETNOSAINS'">
    <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="flex items-center gap-4">
            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-teal-100 dark:bg-teal-900 text-xl font-bold text-teal-800 dark:text-teal-300">
                {{ Illuminate\Support\Str::of($guru->nama_lengkap)->substr(0, 1)->upper() }}
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $guru->nama_lengkap }}</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $guru->profilGuru?->bidang_studi }} &middot; {{ $guru->profilGuru?->instansiPendidikan?->nama_instansi }}</p>
            </div>
        </div>

        @if($guru->profilGuru?->bio)
            <p class="mt-6 max-w-2xl text-slate-600 dark:text-slate-400">{{ $guru->profilGuru->bio }}</p>
        @endif

        <h2 class="mt-10 text-xl font-bold text-slate-900 dark:text-slate-100">E-Modul Karya {{ $guru->nama_lengkap }}</h2>
        @if($eModul->isEmpty())
            <div class="mt-6"><x-empty-state judul="Belum ada E-Modul yang dipublikasikan." /></div>
        @else
            <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($eModul as $item)
                    @include('publik.partials.kartu-e-modul', ['eModul' => $item])
                @endforeach
            </div>
            <div class="mt-8">{{ $eModul->links() }}</div>
        @endif
    </div>
</x-layout-publik>
