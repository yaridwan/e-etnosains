<x-layout-dashboard judul-seo="Dashboard Guru" :menu="\App\Support\MenuDashboard::guru()">
    <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Selamat Datang, {{ auth()->user()->nama_lengkap }}</h1>
    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Kelola konten pembelajaran etnosains Anda di sini.</p>

    <div class="mt-6 grid grid-cols-2 gap-4 lg:grid-cols-4">
        @foreach([
            ['label' => 'E-Modul', 'nilai' => $statistik['e_modul'], 'ikon' => 'tumpukan', 'warna' => 'teal'],
            ['label' => 'Dipublikasikan', 'nilai' => $statistik['e_modul_terbit'], 'ikon' => 'centang', 'warna' => 'emerald'],
            ['label' => 'Menunggu Review', 'nilai' => $statistik['e_modul_menunggu'], 'ikon' => 'jam', 'warna' => 'amber'],
            ['label' => 'LKPD', 'nilai' => $statistik['lkpd'], 'ikon' => 'clipboard-centang', 'warna' => 'sky'],
            ['label' => 'Observasi', 'nilai' => $statistik['observasi'], 'ikon' => 'mata', 'warna' => 'violet'],
            ['label' => 'Video', 'nilai' => $statistik['video'], 'ikon' => 'putar', 'warna' => 'rose'],
            ['label' => 'Kelas Belajar', 'nilai' => $statistik['kelas'], 'ikon' => 'kelompok', 'warna' => 'teal'],
            ['label' => 'Total Dilihat', 'nilai' => $statistik['total_dilihat'], 'ikon' => 'bintang', 'warna' => 'slate'],
        ] as $kartu)
            <x-kartu-statistik :label="$kartu['label']" :nilai="$kartu['nilai']" :ikon="$kartu['ikon']" :warna="$kartu['warna']" />
        @endforeach
    </div>

    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <x-kartu>
            <div class="flex items-center justify-between">
                <x-judul-seksi ikon="tumpukan" warna="teal">E-Modul Terbaru</x-judul-seksi>
                <a href="{{ route('guru.e-modul.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">Lihat semua</a>
            </div>
            <div class="mt-4 space-y-3">
                @forelse($eModulTerbaru as $item)
                    <div class="flex items-center justify-between gap-3 border-b border-slate-100 dark:border-slate-800 pb-3 last:border-0">
                        <p class="min-w-0 truncate text-sm font-medium text-slate-800 dark:text-slate-100">{{ $item->judul }}</p>
                        <x-status-publikasi :status="$item->status_publikasi" />
                    </div>
                @empty
                    <p class="text-sm text-slate-400 dark:text-slate-500">Belum ada E-Modul.</p>
                @endforelse
            </div>
        </x-kartu>

        <x-kartu>
            <div class="flex items-center justify-between">
                <x-judul-seksi ikon="kelompok" warna="sky">Kelas Belajar Saya</x-judul-seksi>
                <a href="{{ route('guru.kelas.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">Lihat semua</a>
            </div>
            <div class="mt-4 space-y-3">
                @forelse($kelasSaya as $kelas)
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3 last:border-0">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium text-slate-800 dark:text-slate-100">{{ $kelas->nama_kelas }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Kode: {{ $kelas->kode_kelas }}</p>
                        </div>
                        <span class="shrink-0 text-xs text-slate-500 dark:text-slate-400">{{ $kelas->anggota_count }} siswa</span>
                    </div>
                @empty
                    <p class="text-sm text-slate-400 dark:text-slate-500">Belum ada kelas belajar.</p>
                @endforelse
            </div>
        </x-kartu>
    </div>
</x-layout-dashboard>
