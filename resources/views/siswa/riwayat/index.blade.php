<x-layout-dashboard judul-seo="Riwayat Belajar" :menu="\App\Support\MenuDashboard::siswa()">
    <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Riwayat Belajar</h1>

    <x-kartu class="mt-6">
        @if($riwayat->isEmpty())
            <x-empty-state judul="Belum ada riwayat belajar." />
        @else
            <table class="w-full text-left text-sm">
                <thead class="text-xs uppercase text-slate-400 dark:text-slate-500">
                    <tr><th class="pb-2">Konten</th><th class="pb-2">Progres</th><th class="pb-2">Status</th><th class="pb-2">Terakhir Diakses</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($riwayat as $item)
                        <tr>
                            <td class="py-3 font-medium text-slate-700 dark:text-slate-300">{{ $item->modelKonten->judul ?? '-' }} <span class="text-xs text-slate-400 dark:text-slate-500">({{ $item->labelJenis }})</span></td>
                            <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->persentase_baca }}%</td>
                            <td class="py-3"><x-badge :warna="$item->status === 'selesai' ? 'emerald' : 'amber'">{{ ucfirst($item->status) }}</x-badge></td>
                            <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->terakhir_diakses_pada?->translatedFormat('d M Y, H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">{{ $riwayat->links() }}</div>
        @endif
    </x-kartu>
</x-layout-dashboard>
