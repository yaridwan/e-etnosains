<x-layout-dashboard judul-seo="LKPD Saya" :menu="\App\Support\MenuDashboard::guru()">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">LKPD Saya</h1>
        <x-tombol :href="route('guru.lkpd.create')">Buat LKPD</x-tombol>
    </div>

    <x-kartu class="mt-6">
        @if($lkpd->isEmpty())
            <x-empty-state judul="Belum ada LKPD." teks-tombol="Buat LKPD Pertama" :tautan-tombol="route('guru.lkpd.create')" />
        @else
            <table class="w-full text-left text-sm">
                <thead class="text-xs uppercase text-slate-400 dark:text-slate-500">
                    <tr><th class="pb-2">Judul</th><th class="pb-2">Mata Pelajaran</th><th class="pb-2">Dilihat</th><th class="pb-2 text-right">Aksi</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($lkpd as $item)
                        <tr>
                            <td class="py-3 font-medium text-slate-700 dark:text-slate-300">{{ $item->judul }}</td>
                            <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->mataPelajaran->nama_mata_pelajaran }}</td>
                            <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->jumlah_dilihat }}</td>
                            <td class="py-3 text-right space-x-3">
                                <a href="{{ route('guru.lkpd.edit', $item) }}" class="text-sm font-medium text-teal-700 dark:text-teal-400 hover:underline">Ubah</a>
                                <x-form-hapus :aksi="route('guru.lkpd.destroy', $item)" class="inline" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">{{ $lkpd->links() }}</div>
        @endif
    </x-kartu>
</x-layout-dashboard>
