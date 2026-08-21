<x-layout-dashboard judul-seo="Kelas Saya" :menu="\App\Support\MenuDashboard::guru()">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Kelas Belajar Saya</h1>
        <x-tombol :href="route('guru.kelas.create')">Buat Kelas</x-tombol>
    </div>

    <x-kartu class="mt-6">
        @if($kelas->isEmpty())
            <x-empty-state judul="Belum ada kelas belajar." teks-tombol="Buat Kelas" :tautan-tombol="route('guru.kelas.create')" />
        @else
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($kelas as $item)
                    <a href="{{ route('guru.kelas.show', $item) }}" class="block rounded-xl border border-slate-200 dark:border-slate-800 p-4 hover:border-teal-600 dark:hover:border-teal-500">
                        <p class="font-semibold text-slate-800 dark:text-slate-100">{{ $item->nama_kelas }}</p>
                        <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">Kode: {{ $item->kode_kelas }}</p>
                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ $item->anggota_count }} siswa</p>
                    </a>
                @endforeach
            </div>
            <div class="mt-4">{{ $kelas->links() }}</div>
        @endif
    </x-kartu>
</x-layout-dashboard>
