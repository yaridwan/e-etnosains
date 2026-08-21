<x-layout-dashboard judul-seo="Dashboard Administrator" :menu="\App\Support\MenuDashboard::administrator()" label-peran="Dashboard Administrator">
    <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Dashboard Administrator</h1>
    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Ringkasan aktivitas dan konten E-ETNOSAINS.</p>

    <div class="mt-6 grid grid-cols-2 gap-4 lg:grid-cols-4">
        @foreach([
            ['label' => 'Total Pengguna', 'nilai' => $statistik['total_pengguna']],
            ['label' => 'Guru', 'nilai' => $statistik['guru']],
            ['label' => 'Siswa', 'nilai' => $statistik['siswa']],
            ['label' => 'E-Modul', 'nilai' => $statistik['e_modul']],
            ['label' => 'LKPD', 'nilai' => $statistik['lkpd']],
            ['label' => 'Bahan Ajar', 'nilai' => $statistik['bahan_ajar']],
            ['label' => 'Video', 'nilai' => $statistik['video']],
            ['label' => 'Observasi', 'nilai' => $statistik['observasi']],
        ] as $kartu)
            <x-kartu padat>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400 dark:text-slate-500">{{ $kartu['label'] }}</p>
                <p class="mt-1 text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $kartu['nilai'] }}</p>
            </x-kartu>
        @endforeach
    </div>

    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <x-kartu>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-slate-800 dark:text-slate-100">Guru Menunggu Verifikasi</h2>
                <a href="{{ route('admin.verifikasi-guru.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">Lihat semua</a>
            </div>
            <div class="mt-4 space-y-3">
                @forelse($guruMenunggu as $verifikasi)
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3 last:border-0">
                        <div>
                            <p class="text-sm font-medium text-slate-800 dark:text-slate-100">{{ $verifikasi->pengguna->nama_lengkap }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $verifikasi->pengguna->email }}</p>
                        </div>
                        <a href="{{ route('admin.verifikasi-guru.show', $verifikasi) }}" class="text-sm font-medium text-teal-700 dark:text-teal-400 hover:underline">Tinjau</a>
                    </div>
                @empty
                    <p class="text-sm text-slate-400 dark:text-slate-500">Tidak ada guru yang menunggu verifikasi.</p>
                @endforelse
            </div>
        </x-kartu>

        <x-kartu>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-slate-800 dark:text-slate-100">E-Modul Menunggu Review</h2>
                <a href="{{ route('admin.tinjau-e-modul.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">Lihat semua</a>
            </div>
            <div class="mt-4 space-y-3">
                @forelse($eModulMenunggu as $eModul)
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3 last:border-0">
                        <div>
                            <p class="text-sm font-medium text-slate-800 dark:text-slate-100">{{ $eModul->judul }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">oleh {{ $eModul->pengguna->nama_lengkap }}</p>
                        </div>
                        <a href="{{ route('admin.tinjau-e-modul.show', $eModul) }}" class="text-sm font-medium text-teal-700 dark:text-teal-400 hover:underline">Tinjau</a>
                    </div>
                @empty
                    <p class="text-sm text-slate-400 dark:text-slate-500">Tidak ada E-Modul yang menunggu review.</p>
                @endforelse
            </div>
        </x-kartu>
    </div>

    <div class="mt-8">
        <x-kartu>
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">E-Modul Terpopuler</h2>
            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="text-xs uppercase text-slate-400 dark:text-slate-500">
                        <tr><th class="pb-2">Judul</th><th class="pb-2">Dilihat</th><th class="pb-2">Diunduh</th></tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach($eModulPopuler as $eModul)
                            <tr>
                                <td class="py-2 font-medium text-slate-700 dark:text-slate-300">{{ $eModul->judul }}</td>
                                <td class="py-2 text-slate-500 dark:text-slate-400">{{ $eModul->jumlah_dilihat }}</td>
                                <td class="py-2 text-slate-500 dark:text-slate-400">{{ $eModul->jumlah_diunduh }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-kartu>
    </div>
</x-layout-dashboard>
