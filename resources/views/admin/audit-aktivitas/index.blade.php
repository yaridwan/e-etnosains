<x-layout-dashboard judul-seo="Audit Aktivitas" :menu="\App\Support\MenuDashboard::administrator()">
    <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Audit Aktivitas</h1>
    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Catatan aktivitas penting di dalam sistem.</p>

    <x-kartu class="mt-6">
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
                    <tr><td colspan="4"><x-empty-state judul="Belum ada aktivitas tercatat." /></td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $audit->links() }}</div>
    </x-kartu>
</x-layout-dashboard>
