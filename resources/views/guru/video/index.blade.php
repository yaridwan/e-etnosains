<x-layout-dashboard judul-seo="Video Saya" :menu="\App\Support\MenuDashboard::guru()">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900">Video Pembelajaran Saya</h1>
        <x-tombol :href="route('guru.video.create')">Tambah Video</x-tombol>
    </div>

    <x-kartu class="mt-6">
        @if($video->isEmpty())
            <x-empty-state judul="Belum ada video pembelajaran." teks-tombol="Tambah Video" :tautan-tombol="route('guru.video.create')" />
        @else
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($video as $item)
                    <div class="rounded-xl border border-slate-200 p-3">
                        <img src="{{ $item->tautanThumbnail() }}" class="aspect-video w-full rounded-lg object-cover" alt="{{ $item->judul }}">
                        <p class="mt-2 text-sm font-medium text-slate-700">{{ $item->judul }}</p>
                        <div class="mt-2 flex justify-between text-sm">
                            <a href="{{ route('guru.video.edit', $item) }}" class="font-medium text-teal-700 hover:underline">Ubah</a>
                            <x-form-hapus :aksi="route('guru.video.destroy', $item)" />
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">{{ $video->links() }}</div>
        @endif
    </x-kartu>
</x-layout-dashboard>
