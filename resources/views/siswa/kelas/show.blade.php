<x-layout-dashboard judul-seo="Detail Kelas" :menu="\App\Support\MenuDashboard::siswa()">
    <a href="{{ route('siswa.kelas.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">&larr; Kembali</a>
    <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $kelas->nama_kelas }}</h1>
    <p class="text-sm text-slate-500 dark:text-slate-400">Guru: {{ $kelas->pengguna->nama_lengkap }}</p>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <x-kartu>
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">Materi Kelas</h2>
            <div class="mt-3 divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($konten as $item)
                    <div class="flex items-center justify-between py-2 text-sm">
                        <div>
                            <span class="text-slate-700 dark:text-slate-300">{{ $item['model']->judul }}</span>
                            <x-badge warna="slate" class="ml-2">{{ $item['jenis'] }}</x-badge>
                        </div>
                        @if($item['jenisKonten'] === 'e_modul')
                            <a href="{{ route('e-modul.show', $item['model']) }}" class="text-teal-700 dark:text-teal-400 hover:underline">Buka</a>
                        @elseif($item['jenisKonten'] === 'lkpd')
                            <a href="{{ route('lkpd.show', $item['model']) }}" class="text-teal-700 dark:text-teal-400 hover:underline">Buka</a>
                        @else
                            <a href="{{ route('observasi.show', $item['model']) }}" class="text-teal-700 dark:text-teal-400 hover:underline">Buka</a>
                        @endif
                    </div>
                @empty
                    <p class="py-2 text-sm text-slate-400 dark:text-slate-500">Belum ada materi yang ditambahkan guru.</p>
                @endforelse
            </div>
        </x-kartu>

        <x-kartu>
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">Tugas Kelas</h2>
            <div class="mt-3 divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($kelas->tugasKelas as $tugas)
                    <div class="flex items-center justify-between py-2 text-sm">
                        <div>
                            <p class="font-medium text-slate-700 dark:text-slate-300">{{ $tugas->judul }}</p>
                            <p class="text-xs text-slate-400 dark:text-slate-500">Batas: {{ $tugas->batas_waktu?->translatedFormat('d M Y, H:i') ?? '-' }}</p>
                        </div>
                        <a href="{{ route('siswa.tugas.show', $tugas) }}" class="text-teal-700 dark:text-teal-400 hover:underline">
                            {{ $tugas->pengumpulan->isNotEmpty() ? 'Lihat' : 'Kerjakan' }}
                        </a>
                    </div>
                @empty
                    <p class="py-2 text-sm text-slate-400 dark:text-slate-500">Belum ada tugas untuk kelas ini.</p>
                @endforelse
            </div>
        </x-kartu>
    </div>
</x-layout-dashboard>
