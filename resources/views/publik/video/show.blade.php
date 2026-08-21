<x-layout-publik :judul-seo="$video->judul.' | E-ETNOSAINS'" :deskripsi-seo="$video->deskripsi">
    <div class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        <nav class="text-sm text-slate-500 dark:text-slate-400">
            <a href="{{ route('beranda') }}" class="hover:text-teal-700 dark:hover:text-teal-400">Beranda</a> /
            <a href="{{ route('video.index') }}" class="hover:text-teal-700 dark:hover:text-teal-400">Video</a> /
            <span class="text-slate-700 dark:text-slate-300">{{ $video->judul }}</span>
        </nav>

        <h1 class="mt-4 text-3xl font-bold text-slate-900 dark:text-slate-100">{{ $video->judul }}</h1>
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Oleh {{ $video->pengguna->nama_lengkap }}</p>

        <div class="mt-6 aspect-video w-full overflow-hidden rounded-2xl bg-black">
            <iframe src="{{ $video->tautanEmbed() }}" class="h-full w-full" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>
        </div>

        <p class="mt-6 text-slate-700 dark:text-slate-300">{{ $video->deskripsi }}</p>

        @if($video->eModul)
            <a href="{{ route('e-modul.show', $video->eModul) }}" class="mt-4 inline-block text-sm text-teal-700 dark:text-teal-400 hover:underline">Terkait E-Modul: {{ $video->eModul->judul }} &rarr;</a>
        @endif
    </div>
</x-layout-publik>
