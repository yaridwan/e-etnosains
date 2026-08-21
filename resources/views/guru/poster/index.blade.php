<x-layout-dashboard judul-seo="Poster Saya" :menu="\App\Support\MenuDashboard::guru()">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Poster Saya</h1>
        <x-tombol :href="route('guru.poster.create')">Tambah Poster</x-tombol>
    </div>

    <x-kartu class="mt-6">
        @if($poster->isEmpty())
            <x-empty-state judul="Belum ada poster." teks-tombol="Tambah Poster" :tautan-tombol="route('guru.poster.create')" />
        @else
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                @foreach($poster as $item)
                    <div class="rounded-xl border border-slate-200 dark:border-slate-800 p-3">
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($item->gambar) }}" class="aspect-[3/4] w-full rounded-lg object-cover" alt="{{ $item->judul }}">
                        <p class="mt-2 truncate text-sm font-medium text-slate-700 dark:text-slate-300">{{ $item->judul }}</p>
                        <div class="mt-2 flex justify-between text-sm">
                            <a href="{{ route('guru.poster.edit', $item) }}" class="font-medium text-teal-700 dark:text-teal-400 hover:underline">Ubah</a>
                            <x-form-hapus :aksi="route('guru.poster.destroy', $item)" />
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">{{ $poster->links() }}</div>
        @endif
    </x-kartu>
</x-layout-dashboard>
