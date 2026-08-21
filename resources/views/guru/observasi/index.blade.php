<x-layout-dashboard judul-seo="Observasi Saya" :menu="\App\Support\MenuDashboard::guru()">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Observasi Saya</h1>
        <x-tombol :href="route('guru.observasi.create')">Buat Observasi</x-tombol>
    </div>

    <x-kartu class="mt-6">
        @if($observasi->isEmpty())
            <x-empty-state judul="Belum ada aktivitas observasi." teks-tombol="Buat Observasi" :tautan-tombol="route('guru.observasi.create')" />
        @else
            <table class="w-full text-left text-sm">
                <thead class="text-xs uppercase text-slate-400 dark:text-slate-500">
                    <tr><th class="pb-2">Judul</th><th class="pb-2">Pengumpulan</th><th class="pb-2">Batas Waktu</th><th class="pb-2 text-right">Aksi</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($observasi as $item)
                        <tr>
                            <td class="py-3 font-medium text-slate-700 dark:text-slate-300">{{ $item->judul }}</td>
                            <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->pengumpulan_count }}</td>
                            <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->batas_pengumpulan?->translatedFormat('d M Y') ?? '-' }}</td>
                            <td class="py-3 text-right space-x-3">
                                <a href="{{ route('guru.pengumpulan-observasi.index', ['observasi' => $item->id]) }}" class="text-sm font-medium text-slate-600 dark:text-slate-400 hover:underline">Pengumpulan</a>
                                <a href="{{ route('guru.observasi.edit', $item) }}" class="text-sm font-medium text-teal-700 dark:text-teal-400 hover:underline">Ubah</a>
                                <x-form-hapus :aksi="route('guru.observasi.destroy', $item)" class="inline" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">{{ $observasi->links() }}</div>
        @endif
    </x-kartu>
</x-layout-dashboard>
