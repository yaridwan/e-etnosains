<x-layout-dashboard judul-seo="Tinjau E-Modul" :menu="\App\Support\MenuDashboard::administrator()">
    <a href="{{ route('admin.tinjau-e-modul.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">&larr; Kembali</a>

    <div class="mt-2 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $eModul->judul }}</h1>
        <x-status-publikasi :status="$eModul->status_publikasi" />
    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            <x-kartu>
                <h2 class="font-semibold text-slate-800 dark:text-slate-100">Metadata</h2>
                <dl class="mt-4 grid grid-cols-1 gap-4 text-sm sm:grid-cols-2">
                    <div><dt class="text-slate-400 dark:text-slate-500">Penulis</dt><dd class="font-medium text-slate-700 dark:text-slate-300">{{ $eModul->pengguna->nama_lengkap }}</dd></div>
                    <div><dt class="text-slate-400 dark:text-slate-500">Mata Pelajaran</dt><dd class="font-medium text-slate-700 dark:text-slate-300">{{ $eModul->mataPelajaran->nama_mata_pelajaran }}</dd></div>
                    <div><dt class="text-slate-400 dark:text-slate-500">Jenjang</dt><dd class="font-medium text-slate-700 dark:text-slate-300">{{ $eModul->jenjangPendidikan->nama_jenjang }}</dd></div>
                    <div><dt class="text-slate-400 dark:text-slate-500">Topik Etnosains</dt><dd class="font-medium text-slate-700 dark:text-slate-300">{{ $eModul->topikEtnosains?->nama_topik ?? '-' }}</dd></div>
                </dl>
            </x-kartu>

            <x-kartu>
                <h2 class="font-semibold text-slate-800 dark:text-slate-100">Ringkasan &amp; Deskripsi</h2>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">{{ $eModul->ringkasan }}</p>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ $eModul->deskripsi }}</p>
            </x-kartu>

            <x-kartu>
                <h2 class="font-semibold text-slate-800 dark:text-slate-100">Eksplorasi Etnosains</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div><dt class="font-medium text-slate-700 dark:text-slate-300">Pengetahuan Lokal</dt><dd class="text-slate-500 dark:text-slate-400">{{ $eModul->pengetahuan_lokal }}</dd></div>
                    <div><dt class="font-medium text-slate-700 dark:text-slate-300">Konsep Sains</dt><dd class="text-slate-500 dark:text-slate-400">{{ $eModul->konsep_sains }}</dd></div>
                    <div><dt class="font-medium text-slate-700 dark:text-slate-300">Nilai Karakter</dt><dd class="text-slate-500 dark:text-slate-400">{{ $eModul->nilai_karakter }}</dd></div>
                </dl>
            </x-kartu>

            @if($eModul->berkas_pdf)
                <x-kartu>
                    <h2 class="font-semibold text-slate-800 dark:text-slate-100">Berkas PDF</h2>
                    <iframe src="{{ \Illuminate\Support\Facades\Storage::url($eModul->berkas_pdf) }}" class="mt-3 h-96 w-full rounded-lg border border-slate-200 dark:border-slate-800"></iframe>
                </x-kartu>
            @endif

            <x-kartu>
                <h2 class="font-semibold text-slate-800 dark:text-slate-100">Riwayat Status</h2>
                <div class="mt-4 space-y-3">
                    @forelse($eModul->riwayatStatus as $riwayat)
                        <div class="border-b border-slate-100 dark:border-slate-800 pb-3 text-sm last:border-0">
                            <p class="font-medium text-slate-700 dark:text-slate-300">{{ $riwayat->status_sebelum }} &rarr; {{ $riwayat->status_sesudah }}</p>
                            <p class="text-slate-500 dark:text-slate-400">{{ $riwayat->catatan }}</p>
                            <p class="text-xs text-slate-400 dark:text-slate-500">{{ $riwayat->dibuat_pada?->translatedFormat('d M Y, H:i') }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-slate-400 dark:text-slate-500">Belum ada riwayat.</p>
                    @endforelse
                </div>
            </x-kartu>
        </div>

        <x-kartu>
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">Keputusan</h2>

            <form method="POST" action="{{ route('admin.tinjau-e-modul.setujui', $eModul) }}" class="mt-4 space-y-2">
                @csrf
                <x-textarea name="catatan" placeholder="Catatan (opsional)..." :baris="2" />
                <x-tombol type="submit" class="w-full">Setujui &amp; Publikasikan</x-tombol>
            </form>

            <form method="POST" action="{{ route('admin.tinjau-e-modul.minta-perbaikan', $eModul) }}" class="mt-3 space-y-2">
                @csrf
                <x-textarea name="catatan" placeholder="Catatan perbaikan..." wajib :baris="2" />
                <x-tombol type="submit" varian="sekunder" class="w-full">Minta Perbaikan</x-tombol>
            </form>

            <form method="POST" action="{{ route('admin.tinjau-e-modul.tolak', $eModul) }}" class="mt-3 space-y-2">
                @csrf
                <x-textarea name="catatan" placeholder="Alasan penolakan..." wajib :baris="2" />
                <x-tombol type="submit" varian="bahaya" class="w-full">Tolak</x-tombol>
            </form>
        </x-kartu>
    </div>
</x-layout-dashboard>
