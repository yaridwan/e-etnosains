<x-layout-dashboard judul-seo="Dashboard Guru" :menu="\App\Support\MenuDashboard::guru()">
    <h1 class="text-2xl font-bold text-slate-900">Selamat Datang, {{ auth()->user()->nama_lengkap }}</h1>
    <p class="mt-1 text-sm text-slate-500">Kelola konten pembelajaran etnosains Anda di sini.</p>

    <div class="mt-6 grid grid-cols-2 gap-4 lg:grid-cols-4">
        @foreach([
            ['label' => 'E-Modul', 'nilai' => $statistik['e_modul']],
            ['label' => 'Dipublikasikan', 'nilai' => $statistik['e_modul_terbit']],
            ['label' => 'Menunggu Review', 'nilai' => $statistik['e_modul_menunggu']],
            ['label' => 'LKPD', 'nilai' => $statistik['lkpd']],
            ['label' => 'Observasi', 'nilai' => $statistik['observasi']],
            ['label' => 'Video', 'nilai' => $statistik['video']],
            ['label' => 'Kelas Belajar', 'nilai' => $statistik['kelas']],
            ['label' => 'Total Dilihat', 'nilai' => $statistik['total_dilihat']],
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
                <h2 class="font-semibold text-slate-800">E-Modul Terbaru</h2>
                <a href="{{ route('guru.e-modul.index') }}" class="text-sm text-teal-700 hover:underline">Lihat semua</a>
            </div>
            <div class="mt-4 space-y-3">
                @forelse($eModulTerbaru as $item)
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3 last:border-0">
                        <p class="text-sm font-medium text-slate-800">{{ $item->judul }}</p>
                        <x-status-publikasi :status="$item->status_publikasi" />
                    </div>
                @empty
                    <p class="text-sm text-slate-400">Belum ada E-Modul.</p>
                @endforelse
            </div>
        </x-kartu>

        <x-kartu>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-slate-800">Kelas Belajar Saya</h2>
                <a href="{{ route('guru.kelas.index') }}" class="text-sm text-teal-700 hover:underline">Lihat semua</a>
            </div>
            <div class="mt-4 space-y-3">
                @forelse($kelasSaya as $kelas)
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3 last:border-0">
                        <div>
                            <p class="text-sm font-medium text-slate-800">{{ $kelas->nama_kelas }}</p>
                            <p class="text-xs text-slate-500">Kode: {{ $kelas->kode_kelas }}</p>
                        </div>
                        <span class="text-xs text-slate-500">{{ $kelas->anggota_count }} siswa</span>
                    </div>
                @empty
                    <p class="text-sm text-slate-400">Belum ada kelas belajar.</p>
                @endforelse
            </div>
        </x-kartu>
    </div>
</x-layout-dashboard>
