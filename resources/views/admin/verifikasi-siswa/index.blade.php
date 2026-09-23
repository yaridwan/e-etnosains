<x-layout-dashboard judul-seo="Verifikasi Siswa" :menu="\App\Support\MenuDashboard::administrator()">
    <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Verifikasi Siswa</h1>
    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Tinjau dan setujui pendaftaran akun siswa baru.</p>

    <form method="GET" class="mt-4 flex flex-wrap items-end gap-3">
        <div class="w-full sm:w-64">
            <x-input type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama/email siswa..." />
        </div>
        <div class="w-full sm:w-48">
            <x-select name="status" placeholder="Menunggu Verifikasi (default)" :opsi="['semua' => 'Tampil Semua', 'menunggu_verifikasi' => 'Menunggu Verifikasi', 'aktif' => 'Aktif', 'ditolak' => 'Ditolak', 'nonaktif' => 'Nonaktif']" :selected="request('status')" />
        </div>
        <x-tombol type="submit" varian="sekunder">Filter</x-tombol>
    </form>

    <x-kartu class="mt-6">
        <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="text-xs uppercase text-slate-400 dark:text-slate-500">
                <tr><th class="pb-2">Nama</th><th class="pb-2">Instansi</th><th class="pb-2">Status</th><th class="pb-2 text-right">Aksi</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($siswa as $item)
                    <tr>
                        <td class="py-3">
                            <p class="font-medium text-slate-700 dark:text-slate-300">{{ $item->nama_lengkap }}</p>
                            <p class="text-xs text-slate-400 dark:text-slate-500">{{ $item->email }}</p>
                        </td>
                        <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->profilSiswa?->instansiPendidikan?->nama_instansi }}</td>
                        <td class="py-3">
                            <x-badge :warna="match($item->status_akun->value) {
                                'aktif' => 'emerald', 'ditolak' => 'rose', 'nonaktif' => 'slate', default => 'amber'
                            }">{{ $item->status_akun->label() }}</x-badge>
                        </td>
                        <td class="py-3 text-right">
                            <x-tombol-ikon :href="route('admin.verifikasi-siswa.show', $item)" ikon="mata" label="Tinjau" />
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4"><x-empty-state judul="Tidak ada pendaftaran siswa." deskripsi="{{ request('q') || request('status') ? 'Tidak ada pendaftaran yang cocok dengan filter.' : null }}" /></td></tr>
                @endforelse
            </tbody>
        </table>
        </div>

        <div class="mt-4">{{ $siswa->links() }}</div>
    </x-kartu>
</x-layout-dashboard>
