<x-layout-dashboard judul-seo="Dashboard Siswa" :menu="\App\Support\MenuDashboard::siswa()">
    <h1 class="text-2xl font-bold text-slate-900">Halo, {{ auth()->user()->nama_lengkap }}!</h1>
    <p class="mt-1 text-sm text-slate-500">Terus belajar sains dari kearifan lokal Indonesia.</p>

    @foreach($pengumumanAktif as $pengumuman)
        <x-alert jenis="info" class="mt-4">{{ $pengumuman->judul }}: {{ $pengumuman->isi }}</x-alert>
    @endforeach

    <div class="mt-6 grid grid-cols-2 gap-4 lg:grid-cols-5">
        @foreach([
            ['label' => 'E-Modul Dipelajari', 'nilai' => $statistik['e_modul_dipelajari']],
            ['label' => 'Selesai', 'nilai' => $statistik['e_modul_selesai']],
            ['label' => 'Observasi Dinilai', 'nilai' => $statistik['observasi_selesai']],
            ['label' => 'Kelas Diikuti', 'nilai' => $statistik['kelas']],
            ['label' => 'Tugas Belum Selesai', 'nilai' => $statistik['tugas_belum']],
        ] as $kartu)
            <x-kartu padat>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">{{ $kartu['label'] }}</p>
                <p class="mt-1 text-2xl font-bold text-slate-900">{{ $kartu['nilai'] }}</p>
            </x-kartu>
        @endforeach
    </div>

    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <x-kartu>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-slate-800">Kelas Saya</h2>
                <a href="{{ route('siswa.kelas.index') }}" class="text-sm text-teal-700 hover:underline">Lihat semua</a>
            </div>
            <div class="mt-4 space-y-3">
                @forelse($kelasSaya as $kelas)
                    <a href="{{ route('siswa.kelas.show', $kelas) }}" class="block border-b border-slate-100 pb-3 text-sm last:border-0">
                        <p class="font-medium text-slate-800">{{ $kelas->nama_kelas }}</p>
                    </a>
                @empty
                    <p class="text-sm text-slate-400">Anda belum bergabung ke kelas manapun.</p>
                @endforelse
            </div>
        </x-kartu>

        <x-kartu>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-slate-800">Kemajuan Belajar Terbaru</h2>
                <a href="{{ route('siswa.riwayat.index') }}" class="text-sm text-teal-700 hover:underline">Lihat semua</a>
            </div>
            <div class="mt-4 space-y-3">
                @forelse($kemajuanTerbaru as $item)
                    <div class="border-b border-slate-100 pb-3 last:border-0">
                        <div class="flex items-center justify-between text-sm">
                            <span class="font-medium text-slate-800">{{ ucfirst(str_replace('_',' ',$item->jenis_konten)) }} #{{ $item->id_referensi }}</span>
                            <span class="text-slate-500">{{ $item->persentase_baca }}%</span>
                        </div>
                        <div class="mt-1.5 h-1.5 w-full rounded-full bg-slate-100">
                            <div class="h-1.5 rounded-full bg-teal-600" style="width: {{ $item->persentase_baca }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-400">Belum ada aktivitas belajar.</p>
                @endforelse
            </div>
        </x-kartu>
    </div>
</x-layout-dashboard>
