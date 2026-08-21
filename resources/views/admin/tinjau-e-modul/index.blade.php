<x-layout-dashboard judul-seo="Tinjau E-Modul" :menu="\App\Support\MenuDashboard::administrator()">
    <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Tinjau E-Modul</h1>
    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Daftar E-Modul yang diajukan guru untuk dipublikasikan.</p>

    <x-kartu class="mt-6">
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
                            <a href="{{ route('admin.tinjau-e-modul.show', $item) }}" class="text-sm font-medium text-teal-700 dark:text-teal-400 hover:underline">Tinjau</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4"><x-empty-state judul="Tidak ada E-Modul yang perlu ditinjau." /></td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $eModul->links() }}</div>
    </x-kartu>
</x-layout-dashboard>
