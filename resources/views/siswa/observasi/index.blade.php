<x-layout-dashboard judul-seo="Observasi Saya" :menu="\App\Support\MenuDashboard::siswa()">
    <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Observasi Saya</h1>

    <x-kartu class="mt-6">
        @if($observasi->isEmpty())
            <x-empty-state judul="Belum ada aktivitas observasi tersedia." />
        @else
            <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-xs uppercase text-slate-400 dark:text-slate-500">
                    <tr><th class="pb-2">Judul</th><th class="pb-2">Batas Waktu</th><th class="pb-2">Status</th><th class="pb-2 text-right">Aksi</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($observasi as $item)
                        @php($status = $item->pengumpulan->first()?->status ?? 'belum')
                        <tr>
                            <td class="py-3 font-medium text-slate-700 dark:text-slate-300">{{ $item->judul }}</td>
                            <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->batas_pengumpulan?->translatedFormat('d M Y') ?? '-' }}</td>
                            <td class="py-3">
                                <x-badge :warna="match($status) { 'dinilai' => 'emerald', 'dikirim' => 'amber', default => 'slate' }">
                                    {{ match($status) { 'dinilai' => 'Dinilai', 'dikirim' => 'Menunggu Penilaian', default => 'Belum Dikerjakan' } }}
                                </x-badge>
                            </td>
                            <td class="py-3 text-right">
                                <x-tombol-ikon :href="route('siswa.observasi.show', $item)" :ikon="$status === 'belum' ? 'pensil-kotak' : 'mata'" :label="$status === 'belum' ? 'Kerjakan' : 'Lihat'" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <div class="mt-4">{{ $observasi->links() }}</div>
        @endif
    </x-kartu>
</x-layout-dashboard>
