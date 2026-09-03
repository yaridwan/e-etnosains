<x-layout-dashboard judul-seo="Audit Aktivitas" :menu="\App\Support\MenuDashboard::administrator()">
    <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Audit Aktivitas</h1>
    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Catatan aktivitas penting di dalam sistem.</p>

    <form method="GET" class="mt-4 flex flex-wrap items-end gap-3">
        <div class="w-full sm:w-56">
            <x-input type="search" name="q" value="{{ request('q') }}" placeholder="Cari aktivitas/pengguna..." />
        </div>
        <div class="w-full sm:w-44">
            <x-select name="modul" placeholder="Semua Modul" :opsi="$daftarModul" :selected="request('modul')" />
        </div>
        <div class="w-full sm:w-40">
            <x-input type="date" name="dari" label="Dari" value="{{ request('dari') }}" />
        </div>
        <div class="w-full sm:w-40">
            <x-input type="date" name="sampai" label="Sampai" value="{{ request('sampai') }}" />
        </div>
        <x-tombol type="submit" varian="sekunder">Filter</x-tombol>
    </form>

    <x-kartu class="mt-6">
        <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="text-xs uppercase text-slate-400 dark:text-slate-500">
                <tr><th class="pb-2">Waktu</th><th class="pb-2">Pengguna</th><th class="pb-2">Aktivitas</th><th class="pb-2">Modul</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($audit as $item)
                    <tr>
                        <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->dibuat_pada?->translatedFormat('d M Y, H:i') }}</td>
                        <td class="py-3 font-medium text-slate-700 dark:text-slate-300">{{ $item->pengguna?->nama_lengkap ?? 'Sistem' }}</td>
                        <td class="py-3 text-slate-600 dark:text-slate-400">{{ $item->aktivitas }}</td>
                        <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->modul }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4"><x-empty-state judul="Belum ada aktivitas tercatat." deskripsi="{{ request()->anyFilled(['q', 'modul', 'dari', 'sampai']) ? 'Tidak ada aktivitas yang cocok dengan filter.' : null }}" /></td></tr>
                @endforelse
            </tbody>
        </table>
        </div>

        <div class="mt-4">{{ $audit->links() }}</div>
    </x-kartu>
</x-layout-dashboard>
