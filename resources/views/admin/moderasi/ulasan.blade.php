<x-layout-dashboard judul-seo="Moderasi Ulasan" :menu="\App\Support\MenuDashboard::administrator()">
    <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Moderasi Ulasan</h1>
    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Tinjau ulasan siswa sebelum tampil di halaman publik.</p>

    <form method="GET" class="mt-4 flex flex-wrap items-end gap-3">
        <div class="w-full sm:w-64">
            <x-input type="search" name="q" value="{{ request('q') }}" placeholder="Cari komentar/pengulas..." />
        </div>
        <div class="w-full sm:w-56">
            <x-select name="status" placeholder="Semua Status" :opsi="['menunggu' => 'Menunggu', 'disetujui' => 'Disetujui', 'ditolak' => 'Ditolak']" :selected="request('status')" />
        </div>
        <x-tombol type="submit" varian="sekunder">Filter</x-tombol>
    </form>

    <x-kartu class="mt-6">
        @if($ulasan->isEmpty())
            <x-empty-state judul="Belum ada ulasan." deskripsi="{{ request('q') || request('status') ? 'Tidak ada ulasan yang cocok dengan filter.' : 'Ulasan dari siswa akan muncul di sini untuk dimoderasi.' }}" />
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="text-xs uppercase text-slate-400 dark:text-slate-500">
                        <tr>
                            <th class="pb-2">Konten</th>
                            <th class="pb-2">Pengulas</th>
                            <th class="pb-2">Rating</th>
                            <th class="pb-2">Komentar</th>
                            <th class="pb-2">Status</th>
                            <th class="pb-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach($ulasan as $item)
                            <tr>
                                <td class="py-3">
                                    <p class="font-medium text-slate-700 dark:text-slate-300">{{ $item->judulKonten ?? '(konten dihapus)' }}</p>
                                    <p class="text-xs text-slate-400 dark:text-slate-500">{{ $item->labelJenis }}</p>
                                </td>
                                <td class="py-3 text-slate-600 dark:text-slate-400">{{ $item->pengguna?->nama_lengkap ?? '-' }}</td>
                                <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->rating }}/5</td>
                                <td class="max-w-xs py-3 text-slate-500 dark:text-slate-400">{{ Str::limit($item->komentar, 90) ?: '-' }}</td>
                                <td class="py-3">
                                    <x-badge :warna="match ($item->status_moderasi) { 'disetujui' => 'emerald', 'ditolak' => 'rose', default => 'amber' }">
                                        {{ ucfirst($item->status_moderasi) }}
                                    </x-badge>
                                </td>
                                <td class="py-3 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        @if($item->status_moderasi !== 'disetujui')
                                            <form method="POST" action="{{ route('admin.moderasi-ulasan.setujui', $item) }}">
                                                @csrf
                                                <x-tombol-ikon type="submit" ikon="centang" label="Setujui" varian="sukses" />
                                            </form>
                                        @endif
                                        @if($item->status_moderasi !== 'ditolak')
                                            <form method="POST" action="{{ route('admin.moderasi-ulasan.tolak', $item) }}">
                                                @csrf
                                                <x-tombol-ikon type="submit" ikon="silang" label="Tolak" varian="peringatan" />
                                            </form>
                                        @endif
                                        <x-form-hapus :aksi="route('admin.moderasi-ulasan.destroy', $item)" pesan="Hapus ulasan ini secara permanen?" />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $ulasan->links() }}</div>
        @endif
    </x-kartu>
</x-layout-dashboard>
