<x-layout-publik judul-seo="Video Pembelajaran | E-ETNOSAINS">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-slate-900">Video Pembelajaran</h1>
        <p class="mt-2 text-slate-500">Video pembelajaran berbasis kearifan lokal.</p>

        @if($video->isEmpty())
            <div class="mt-8"><x-empty-state judul="Belum ada video yang dipublikasikan." /></div>
        @else
            <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($video as $item)
                    <a href="{{ route('video.show', $item) }}" class="block overflow-hidden rounded-2xl border border-slate-200 bg-white hover:border-teal-600">
                        <img src="{{ $item->tautanThumbnail() }}" class="aspect-video w-full object-cover" alt="{{ $item->judul }}">
                        <div class="p-4">
                            <p class="font-semibold text-slate-800">{{ $item->judul }}</p>
                            <p class="mt-1 text-xs text-slate-400">{{ $item->pengguna->nama_lengkap }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-8">{{ $video->links() }}</div>
        @endif
    </div>
</x-layout-publik>
