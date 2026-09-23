<x-layout-dashboard judul-seo="Dashboard Administrator" :menu="\App\Support\MenuDashboard::administrator()" label-peran="Dashboard Administrator">
    <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Dashboard Administrator</h1>
    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Ringkasan aktivitas dan konten E-ETNOSAINS.</p>

    <div class="mt-6 grid grid-cols-2 gap-4 lg:grid-cols-4">
        @foreach([
            ['label' => 'Total Pengguna', 'nilai' => $statistik['total_pengguna'], 'ikon' => 'pengguna', 'warna' => 'teal'],
            ['label' => 'Guru', 'nilai' => $statistik['guru'], 'ikon' => 'kelompok', 'warna' => 'sky'],
            ['label' => 'Siswa', 'nilai' => $statistik['siswa'], 'ikon' => 'lingkaran-pengguna', 'warna' => 'violet'],
            ['label' => 'E-Modul', 'nilai' => $statistik['e_modul'], 'ikon' => 'tumpukan', 'warna' => 'teal'],
            ['label' => 'LKPD', 'nilai' => $statistik['lkpd'], 'ikon' => 'clipboard-centang', 'warna' => 'amber'],
            ['label' => 'Bahan Ajar', 'nilai' => $statistik['bahan_ajar'], 'ikon' => 'folder', 'warna' => 'slate'],
            ['label' => 'Video', 'nilai' => $statistik['video'], 'ikon' => 'putar', 'warna' => 'rose'],
            ['label' => 'Observasi', 'nilai' => $statistik['observasi'], 'ikon' => 'mata', 'warna' => 'emerald'],
        ] as $kartu)
            <x-kartu-statistik :label="$kartu['label']" :nilai="$kartu['nilai']" :ikon="$kartu['ikon']" :warna="$kartu['warna']" />
        @endforeach
    </div>

    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <x-kartu>
            <div class="flex items-center justify-between">
                <x-judul-seksi ikon="perisai" warna="amber">Guru Menunggu Verifikasi</x-judul-seksi>
                <a href="{{ route('admin.verifikasi-guru.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">Lihat semua</a>
            </div>
            <div class="mt-4 space-y-3">
                @forelse($guruMenunggu as $verifikasi)
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3 last:border-0">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium text-slate-800 dark:text-slate-100">{{ $verifikasi->pengguna->nama_lengkap }}</p>
                            <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ $verifikasi->pengguna->email }}</p>
                        </div>
                        <x-tombol-ikon :href="route('admin.verifikasi-guru.show', $verifikasi)" ikon="mata" label="Tinjau" />
                    </div>
                @empty
                    <p class="text-sm text-slate-400 dark:text-slate-500">Tidak ada guru yang menunggu verifikasi.</p>
                @endforelse
            </div>
        </x-kartu>

        <x-kartu>
            <div class="flex items-center justify-between">
                <x-judul-seksi ikon="lingkaran-pengguna" warna="sky">Siswa Menunggu Persetujuan</x-judul-seksi>
                <a href="{{ route('admin.verifikasi-siswa.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">Lihat semua</a>
            </div>
            <div class="mt-4 space-y-3">
                @forelse($siswaMenunggu as $item)
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3 last:border-0">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium text-slate-800 dark:text-slate-100">{{ $item->nama_lengkap }}</p>
                            <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ $item->email }}</p>
                        </div>
                        <x-tombol-ikon :href="route('admin.verifikasi-siswa.show', $item)" ikon="mata" label="Tinjau" />
                    </div>
                @empty
                    <p class="text-sm text-slate-400 dark:text-slate-500">Tidak ada siswa yang menunggu persetujuan.</p>
                @endforelse
            </div>
        </x-kartu>

        <x-kartu>
            <div class="flex items-center justify-between">
                <x-judul-seksi ikon="cari" warna="violet">E-Modul Menunggu Review</x-judul-seksi>
                <a href="{{ route('admin.tinjau-e-modul.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">Lihat semua</a>
            </div>
            <div class="mt-4 space-y-3">
                @forelse($eModulMenunggu as $eModul)
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3 last:border-0">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium text-slate-800 dark:text-slate-100">{{ $eModul->judul }}</p>
                            <p class="truncate text-xs text-slate-500 dark:text-slate-400">oleh {{ $eModul->pengguna->nama_lengkap }}</p>
                        </div>
                        <x-tombol-ikon :href="route('admin.tinjau-e-modul.show', $eModul)" ikon="mata" label="Tinjau" />
                    </div>
                @empty
                    <p class="text-sm text-slate-400 dark:text-slate-500">Tidak ada E-Modul yang menunggu review.</p>
                @endforelse
            </div>
        </x-kartu>
    </div>

    <div class="mt-8">
        <x-kartu>
            <x-judul-seksi ikon="bintang" warna="emerald">E-Modul Terpopuler</x-judul-seksi>
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
