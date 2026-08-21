<x-layout-dashboard judul-seo="Pengumpulan Observasi" :menu="\App\Support\MenuDashboard::guru()">
    <h1 class="text-2xl font-bold text-slate-900">Pengumpulan Observasi</h1>

    <x-kartu class="mt-6">
        @if($pengumpulan->isEmpty())
            <x-empty-state judul="Belum ada pengumpulan observasi dari siswa." />
        @else
            <table class="w-full text-left text-sm">
                <thead class="text-xs uppercase text-slate-400">
                    <tr><th class="pb-2">Siswa</th><th class="pb-2">Observasi</th><th class="pb-2">Status</th><th class="pb-2">Skor</th><th class="pb-2 text-right">Aksi</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($pengumpulan as $item)
                        <tr>
                            <td class="py-3 font-medium text-slate-700">{{ $item->pengguna->nama_lengkap }}</td>
                            <td class="py-3 text-slate-500">{{ $item->observasi->judul }}</td>
                            <td class="py-3"><x-badge :warna="$item->status === 'dinilai' ? 'emerald' : 'amber'">{{ ucfirst($item->status) }}</x-badge></td>
                            <td class="py-3 text-slate-500">{{ $item->skor ?? '-' }}</td>
                            <td class="py-3 text-right"><a href="{{ route('guru.pengumpulan-observasi.show', $item) }}" class="text-sm font-medium text-teal-700 hover:underline">Tinjau &amp; Nilai</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">{{ $pengumpulan->links() }}</div>
        @endif
    </x-kartu>
</x-layout-dashboard>
