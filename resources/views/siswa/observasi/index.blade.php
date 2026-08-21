<x-layout-dashboard judul-seo="Observasi Saya" :menu="\App\Support\MenuDashboard::siswa()">
    <h1 class="text-2xl font-bold text-slate-900">Observasi Saya</h1>

    <x-kartu class="mt-6">
        @if($observasi->isEmpty())
            <x-empty-state judul="Belum ada aktivitas observasi tersedia." />
        @else
            <table class="w-full text-left text-sm">
                <thead class="text-xs uppercase text-slate-400">
                    <tr><th class="pb-2">Judul</th><th class="pb-2">Batas Waktu</th><th class="pb-2">Status</th><th class="pb-2 text-right">Aksi</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($observasi as $item)
                        @php($status = $item->pengumpulan->first()?->status ?? 'belum')
                        <tr>
                            <td class="py-3 font-medium text-slate-700">{{ $item->judul }}</td>
                            <td class="py-3 text-slate-500">{{ $item->batas_pengumpulan?->translatedFormat('d M Y') ?? '-' }}</td>
                            <td class="py-3">
                                <x-badge :warna="match($status) { 'dinilai' => 'emerald', 'dikirim' => 'amber', default => 'slate' }">
                                    {{ match($status) { 'dinilai' => 'Dinilai', 'dikirim' => 'Menunggu Penilaian', default => 'Belum Dikerjakan' } }}
                                </x-badge>
                            </td>
                            <td class="py-3 text-right"><a href="{{ route('siswa.observasi.show', $item) }}" class="text-sm font-medium text-teal-700 hover:underline">{{ $status === 'belum' ? 'Kerjakan' : 'Lihat' }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">{{ $observasi->links() }}</div>
        @endif
    </x-kartu>
</x-layout-dashboard>
