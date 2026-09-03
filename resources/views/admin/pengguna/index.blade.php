<x-layout-dashboard judul-seo="Pengguna" :menu="\App\Support\MenuDashboard::administrator()">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Semua Pengguna</h1>
        <x-tombol-ekspor rute="admin.pengguna.ekspor" />
    </div>

    <form method="GET" class="mt-4 flex flex-wrap items-end gap-3">
        <div class="w-full sm:w-64">
            <x-input type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama/email..." />
        </div>
        <div class="w-full sm:w-48">
            <x-select name="peran" placeholder="Semua Peran" :opsi="['administrator' => 'Administrator', 'guru' => 'Guru', 'siswa' => 'Siswa']" :selected="request('peran')" />
        </div>
        <x-tombol type="submit" varian="sekunder">Filter</x-tombol>
    </form>

    <x-kartu class="mt-6">
        <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="text-xs uppercase text-slate-400 dark:text-slate-500">
                <tr><th class="pb-2">Nama</th><th class="pb-2">Peran</th><th class="pb-2">Status</th><th class="pb-2 text-right">Aksi</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($pengguna as $item)
                    <tr>
                        <td class="py-3">
                            <p class="font-medium text-slate-700 dark:text-slate-300">{{ $item->nama_lengkap }}</p>
                            <p class="text-xs text-slate-400 dark:text-slate-500">{{ $item->email }}</p>
                        </td>
                        <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->peran->pluck('nama_peran')->map(fn($p) => ucfirst($p))->implode(', ') }}</td>
                        <td class="py-3"><x-badge :warna="$item->status_akun->value === 'aktif' ? 'emerald' : 'slate'">{{ $item->status_akun->label() }}</x-badge></td>
                        <td class="py-3 text-right">
                            <x-tombol-ikon :href="route('admin.pengguna.show', $item)" ikon="mata" label="Detail" />
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4"><x-empty-state judul="Tidak ada pengguna ditemukan." /></td></tr>
                @endforelse
            </tbody>
        </table>
        </div>

        <div class="mt-4">{{ $pengguna->links() }}</div>
    </x-kartu>
</x-layout-dashboard>
