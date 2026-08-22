<x-layout-dashboard judul-seo="Dashboard Siswa" :menu="\App\Support\MenuDashboard::siswa()">
    <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Halo, {{ auth()->user()->nama_lengkap }}!</h1>
    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Terus belajar sains dari kearifan lokal Indonesia.</p>

    @foreach($pengumumanAktif as $pengumuman)
        <x-alert jenis="info" class="mt-4">{{ $pengumuman->judul }}: {{ $pengumuman->isi }}</x-alert>
    @endforeach

    <div class="mt-6 grid grid-cols-2 gap-4 lg:grid-cols-5">
        @foreach([
            ['label' => 'E-Modul Dipelajari', 'nilai' => $statistik['e_modul_dipelajari'], 'ikon' => 'tumpukan', 'warna' => 'teal'],
            ['label' => 'Selesai', 'nilai' => $statistik['e_modul_selesai'], 'ikon' => 'centang', 'warna' => 'emerald'],
            ['label' => 'Observasi Dinilai', 'nilai' => $statistik['observasi_selesai'], 'ikon' => 'mata', 'warna' => 'violet'],
            ['label' => 'Kelas Diikuti', 'nilai' => $statistik['kelas'], 'ikon' => 'kelompok', 'warna' => 'sky'],
            ['label' => 'Tugas Belum Selesai', 'nilai' => $statistik['tugas_belum'], 'ikon' => 'lencana-centang', 'warna' => 'amber'],
        ] as $kartu)
            <x-kartu-statistik :label="$kartu['label']" :nilai="$kartu['nilai']" :ikon="$kartu['ikon']" :warna="$kartu['warna']" />
        @endforeach
    </div>

    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <x-kartu>
            <div class="flex items-center justify-between">
                <x-judul-seksi ikon="kelompok" warna="sky">Kelas Saya</x-judul-seksi>
                <a href="{{ route('siswa.kelas.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">Lihat semua</a>
            </div>
            <div class="mt-4 space-y-3">
                @forelse($kelasSaya as $kelas)
                    <a href="{{ route('siswa.kelas.show', $kelas) }}" class="flex items-center gap-2.5 border-b border-slate-100 dark:border-slate-800 pb-3 text-sm last:border-0 hover:text-teal-700 dark:hover:text-teal-400">
                        <x-ikon nama="kelompok" class="h-4 w-4 shrink-0 text-slate-400 dark:text-slate-500" />
                        <span class="truncate font-medium text-slate-800 dark:text-slate-100">{{ $kelas->nama_kelas }}</span>
                    </a>
                @empty
                    <p class="text-sm text-slate-400 dark:text-slate-500">Anda belum bergabung ke kelas manapun.</p>
                @endforelse
            </div>
        </x-kartu>

        <x-kartu>
            <div class="flex items-center justify-between">
                <x-judul-seksi ikon="jam" warna="violet">Kemajuan Belajar Terbaru</x-judul-seksi>
                <a href="{{ route('siswa.riwayat.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">Lihat semua</a>
            </div>
            <div class="mt-4 space-y-3">
                @forelse($kemajuanTerbaru as $item)
                    <div class="border-b border-slate-100 dark:border-slate-800 pb-3 last:border-0">
                        <div class="flex items-center justify-between gap-3 text-sm">
                            <span class="min-w-0 flex-1 truncate font-medium text-slate-800 dark:text-slate-100">
                                @if($item->tautanKonten)
                                    <a href="{{ $item->tautanKonten }}" class="hover:text-teal-700 dark:hover:text-teal-400 hover:underline">{{ $item->judulKonten }}</a>
                                @else
                                    {{ $item->judulKonten ?? $item->labelJenis }}
                                @endif
                            </span>
                            <span class="shrink-0 text-slate-500 dark:text-slate-400">{{ $item->persentase_baca }}%</span>
                        </div>
                        <div class="mt-1.5 h-1.5 w-full rounded-full bg-slate-100 dark:bg-slate-800">
                            <div class="h-1.5 rounded-full bg-teal-600" style="width: {{ $item->persentase_baca }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-400 dark:text-slate-500">Belum ada aktivitas belajar.</p>
                @endforelse
            </div>
        </x-kartu>
    </div>
</x-layout-dashboard>
