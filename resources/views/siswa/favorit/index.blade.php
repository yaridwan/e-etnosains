<x-layout-dashboard judul-seo="Favorit Saya" :menu="\App\Support\MenuDashboard::siswa()">
    <h1 class="text-2xl font-bold text-slate-900">Favorit Saya</h1>

    <x-kartu class="mt-6">
        @if($favorit->isEmpty())
            <x-empty-state judul="Belum ada konten favorit." deskripsi="Tandai E-Modul favorit Anda saat menjelajahi konten." />
        @else
            <div class="divide-y divide-slate-100">
                @foreach($favorit as $item)
                    <div class="flex items-center justify-between py-3 text-sm">
                        <div>
                            <span class="font-medium text-slate-700">{{ $item['model']->judul }}</span>
                            <x-badge warna="slate" class="ml-2">{{ $item['jenis'] }}</x-badge>
                        </div>
                        <x-form-hapus :aksi="route('siswa.favorit.destroy', $item['favorit'])" pesan="Hapus dari favorit?" />
                    </div>
                @endforeach
            </div>
        @endif
    </x-kartu>
</x-layout-dashboard>
