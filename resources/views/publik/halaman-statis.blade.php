<x-layout-publik :judul-seo="$halaman->judul.' | E-ETNOSAINS'">
    <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-slate-900">{{ $halaman->judul }}</h1>
        <div class="prose-etnosains mt-6 text-slate-700">{!! $halaman->konten !!}</div>
    </div>
</x-layout-publik>
