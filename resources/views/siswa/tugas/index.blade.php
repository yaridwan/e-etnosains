<x-layout-dashboard judul-seo="Tugas Saya" :menu="\App\Support\MenuDashboard::siswa()">
    <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Tugas Saya</h1>

    <x-kartu class="mt-6">
        @if($tugas->isEmpty())
            <x-empty-state judul="Belum ada tugas." />
        @else
            <table class="w-full text-left text-sm">
                <thead class="text-xs uppercase text-slate-400 dark:text-slate-500">
                    <tr><th class="pb-2">Judul</th><th class="pb-2">Kelas</th><th class="pb-2">Batas Waktu</th><th class="pb-2">Status</th><th class="pb-2 text-right">Aksi</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($tugas as $item)
                        @php($status = $item->pengumpulan->first())
                        <tr>
                            <td class="py-3 font-medium text-slate-700 dark:text-slate-300">{{ $item->judul }}</td>
                            <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->kelasBelajar->nama_kelas }}</td>
                            <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->batas_waktu?->translatedFormat('d M Y, H:i') ?? '-' }}</td>
                            <td class="py-3">
                                <x-badge :warna="$status?->status === 'dinilai' ? 'emerald' : ($status ? 'amber' : 'rose')">
                                    {{ $status?->status === 'dinilai' ? 'Dinilai' : ($status ? 'Dikirim' : 'Belum Dikerjakan') }}
                                </x-badge>
                            </td>
                            <td class="py-3 text-right"><a href="{{ route('siswa.tugas.show', $item) }}" class="text-sm font-medium text-teal-700 dark:text-teal-400 hover:underline">Lihat</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">{{ $tugas->links() }}</div>
        @endif
    </x-kartu>
</x-layout-dashboard>
