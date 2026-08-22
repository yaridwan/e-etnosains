<x-layout-dashboard judul-seo="Tugas & Penilaian" :menu="\App\Support\MenuDashboard::guru()">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Tugas &amp; Penilaian</h1>
        <x-tombol :href="route('guru.tugas.create')">Buat Tugas</x-tombol>
    </div>

    <x-kartu class="mt-6">
        @if($tugas->isEmpty())
            <x-empty-state judul="Belum ada tugas." teks-tombol="Buat Tugas" :tautan-tombol="route('guru.tugas.create')" />
        @else
            <table class="w-full text-left text-sm">
                <thead class="text-xs uppercase text-slate-400 dark:text-slate-500">
                    <tr><th class="pb-2">Judul</th><th class="pb-2">Kelas</th><th class="pb-2">Batas Waktu</th><th class="pb-2 text-right">Aksi</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($tugas as $item)
                        <tr>
                            <td class="py-3 font-medium text-slate-700 dark:text-slate-300">{{ $item->judul }}</td>
                            <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->kelasBelajar->nama_kelas }}</td>
                            <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->batas_waktu?->translatedFormat('d M Y, H:i') ?? '-' }}</td>
                            <td class="py-3 text-right"><x-tombol-ikon :href="route('guru.tugas.show', $item)" ikon="lencana-centang" label="Lihat & Nilai" /></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">{{ $tugas->links() }}</div>
        @endif
    </x-kartu>
</x-layout-dashboard>
