<x-layout-dashboard judul-seo="Kelas Saya" :menu="\App\Support\MenuDashboard::siswa()">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900">Kelas Saya</h1>
        <x-tombol x-data @click="$dispatch('buka-modal', 'gabung-kelas')">Gabung Kelas</x-tombol>
    </div>

    <x-kartu class="mt-6">
        @if($kelas->isEmpty())
            <x-empty-state judul="Anda belum bergabung ke kelas manapun." deskripsi="Minta kode kelas dari guru Anda untuk bergabung." />
        @else
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($kelas as $item)
                    <a href="{{ route('siswa.kelas.show', $item) }}" class="block rounded-xl border border-slate-200 p-4 hover:border-teal-600">
                        <p class="font-semibold text-slate-800">{{ $item->nama_kelas }}</p>
                        <p class="mt-1 text-xs text-slate-400">Guru: {{ $item->pengguna->nama_lengkap }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </x-kartu>

    <x-modal nama="gabung-kelas" judul="Gabung Kelas Belajar">
        <form method="POST" action="{{ route('siswa.kelas.gabung') }}" class="space-y-4">
            @csrf
            <x-input label="Kode Kelas" name="kode_kelas" wajib placeholder="Contoh: ETNO-AB12CD" />
            <x-tombol type="submit" class="w-full">Gabung</x-tombol>
        </form>
    </x-modal>
</x-layout-dashboard>
