<x-layout-publik :judul-seo="$observasi->judul.' | E-ETNOSAINS'" :deskripsi-seo="$observasi->deskripsi">
    <div class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        <nav class="text-sm text-slate-500 dark:text-slate-400">
            <a href="{{ route('beranda') }}" class="hover:text-teal-700 dark:hover:text-teal-400">Beranda</a> /
            <a href="{{ route('observasi.index') }}" class="hover:text-teal-700 dark:hover:text-teal-400">Observasi</a> /
            <span class="text-slate-700 dark:text-slate-300">{{ $observasi->judul }}</span>
        </nav>

        <h1 class="mt-4 text-3xl font-bold text-slate-900 dark:text-slate-100">{{ $observasi->judul }}</h1>
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Oleh {{ $observasi->pengguna->nama_lengkap }}</p>

        @if($observasi->eModul)
            <a href="{{ route('e-modul.show', $observasi->eModul) }}" class="mt-3 inline-block text-sm text-teal-700 dark:text-teal-400 hover:underline">Terkait E-Modul: {{ $observasi->eModul->judul }} &rarr;</a>
        @endif

        <div class="mt-6 space-y-5 text-slate-700 dark:text-slate-300">
            <p>{{ $observasi->deskripsi }}</p>
            <div><h2 class="font-semibold text-slate-900 dark:text-slate-100">Tujuan</h2><p class="mt-1">{{ $observasi->tujuan }}</p></div>
            <div><h2 class="font-semibold text-slate-900 dark:text-slate-100">Petunjuk</h2><p class="mt-1">{{ $observasi->petunjuk }}</p></div>
            <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div><dt class="text-sm text-slate-400 dark:text-slate-500">Lokasi</dt><dd>{{ $observasi->lokasi_observasi }}</dd></div>
                <div><dt class="text-sm text-slate-400 dark:text-slate-500">Durasi</dt><dd>{{ $observasi->durasi }}</dd></div>
                <div><dt class="text-sm text-slate-400 dark:text-slate-500">Alat dan Bahan</dt><dd>{{ $observasi->alat_dan_bahan }}</dd></div>
                <div><dt class="text-sm text-slate-400 dark:text-slate-500">Aspek Keselamatan</dt><dd>{{ $observasi->aspek_keselamatan }}</dd></div>
            </dl>
        </div>

        @auth
            @if(auth()->user()->isSiswa())
                <x-tombol :href="route('siswa.observasi.show', $observasi)" class="mt-6">Kerjakan Observasi Ini</x-tombol>
            @endif
        @else
            <x-alert jenis="info" class="mt-6">
                <a href="{{ route('masuk') }}" class="font-medium underline">Masuk</a> sebagai siswa untuk mengerjakan observasi ini.
            </x-alert>
        @endauth
    </div>
</x-layout-publik>
