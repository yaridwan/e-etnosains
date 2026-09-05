<x-layout-dashboard judul-seo="Tinjau E-Modul" :menu="\App\Support\MenuDashboard::administrator()">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Tinjau E-Modul</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Daftar E-Modul yang diajukan guru untuk dipublikasikan.</p>
        </div>
        <x-tombol-ekspor rute="admin.tinjau-e-modul.ekspor" />
    </div>

    <form method="GET" class="mt-4 flex flex-wrap items-end gap-3">
        <div class="w-full sm:w-64">
            <x-input type="search" name="q" value="{{ request('q') }}" placeholder="Cari judul/penulis..." />
        </div>
        <div class="w-full sm:w-52">
            <x-select name="status" placeholder="Status Menunggu Aksi" :opsi="['semua' => 'Tampil Semua'] + collect(\App\Enums\StatusPublikasi::cases())->mapWithKeys(fn ($status) => [$status->value => $status->label()])->all()" :selected="request('status')" />
        </div>
        <x-tombol type="submit" varian="sekunder">Filter</x-tombol>
    </form>

    <x-kartu class="mt-6">
        <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="text-xs uppercase text-slate-400 dark:text-slate-500">
                <tr><th class="pb-2">Judul</th><th class="pb-2">Penulis</th><th class="pb-2">Status</th><th class="pb-2 text-right">Aksi</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($eModul as $item)
                    <tr>
                        <td class="py-3 font-medium text-slate-700 dark:text-slate-300">{{ $item->judul }}</td>
                        <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->pengguna->nama_lengkap }}</td>
                        <td class="py-3"><x-status-publikasi :status="$item->status_publikasi" /></td>
                        <td class="py-3 text-right">
                            <x-tombol-ikon :href="route('admin.tinjau-e-modul.show', $item)" ikon="mata" label="Tinjau" />
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4"><x-empty-state judul="Tidak ada E-Modul yang perlu ditinjau." deskripsi="{{ request('q') || request('status') ? 'Tidak ada E-Modul yang cocok dengan filter.' : null }}" /></td></tr>
                @endforelse
            </tbody>
        </table>
        </div>

        <div class="mt-4">{{ $eModul->links() }}</div>
    </x-kartu>
</x-layout-dashboard>
