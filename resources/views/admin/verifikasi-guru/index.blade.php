<x-layout-dashboard judul-seo="Verifikasi Guru" :menu="\App\Support\MenuDashboard::administrator()">
    <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Verifikasi Guru</h1>
    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Tinjau dan setujui pendaftaran akun guru baru.</p>

    <x-kartu class="mt-6">
        <table class="w-full text-left text-sm">
            <thead class="text-xs uppercase text-slate-400 dark:text-slate-500">
                <tr><th class="pb-2">Nama</th><th class="pb-2">Instansi</th><th class="pb-2">Status</th><th class="pb-2 text-right">Aksi</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($verifikasi as $item)
                    <tr>
                        <td class="py-3">
                            <p class="font-medium text-slate-700 dark:text-slate-300">{{ $item->pengguna->nama_lengkap }}</p>
                            <p class="text-xs text-slate-400 dark:text-slate-500">{{ $item->pengguna->email }}</p>
                        </td>
                        <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->pengguna->profilGuru?->instansiPendidikan?->nama_instansi }}</td>
                        <td class="py-3">
                            <x-badge :warna="match($item->status->value) {
                                'disetujui' => 'emerald', 'ditolak' => 'rose', 'perlu_perbaikan' => 'orange', default => 'amber'
                            }">{{ $item->status->label() }}</x-badge>
                        </td>
                        <td class="py-3 text-right">
                            <a href="{{ route('admin.verifikasi-guru.show', $item) }}" class="text-sm font-medium text-teal-700 dark:text-teal-400 hover:underline">Tinjau</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4"><x-empty-state judul="Belum ada pendaftaran guru." /></td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $verifikasi->links() }}</div>
    </x-kartu>
</x-layout-dashboard>
